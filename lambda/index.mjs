import { DynamoDBClient } from "@aws-sdk/client-dynamodb";
import { DynamoDBDocumentClient, PutCommand } from "@aws-sdk/lib-dynamodb";
import { SNSClient, PublishCommand } from "@aws-sdk/client-sns";
import { randomUUID } from "crypto";

const dbClient = new DynamoDBClient({ region: "ap-southeast-2" });
const docClient = DynamoDBDocumentClient.from(dbClient);
const snsClient = new SNSClient({ region: "ap-southeast-2" });

export const handler = async (event) => {
  // 1. Setup Config
  const tableName = "IncidentReports";
  const snsTopicArn = "arn:aws:sns:ap-southeast-2:177815087725:SiteDownAlerts";

  try {
    // 2. Parse Incoming Data (Handle POST body)
    let body;
    if (event.body) {
        body = JSON.parse(event.body);
    } else {
        throw new Error("No data received");
    }

    const { reporter_name, issue_type, description } = body;
    const ticketId = randomUUID();
    const timestamp = new Date().toISOString();

    // 3. Validation
    if (!reporter_name || !description) {
        return { statusCode: 400, body: JSON.stringify({ message: "Missing fields" }) };
    }

    // 4. Save to DynamoDB
    await docClient.send(new PutCommand({
      TableName: tableName,
      Item: {
        ticket_id: ticketId,
        reporter: reporter_name,
        type: issue_type,
        details: description,
        timestamp: timestamp,
        status: "OPEN"
      }
    }));

    // 5. Send Alert Email via SNS
    await snsClient.send(new PublishCommand({
      Message: `New Incident Reported!\n\nID: ${ticketId}\nReporter: ${reporter_name}\nIssue: ${issue_type}\nDetails: ${description}`,
      Subject: `🔥 New Incident: ${issue_type}`,
      TopicArn: snsTopicArn
    }));

    // 6. Return Success ID
    return {
      statusCode: 200,
      body: JSON.stringify({ message: "Report Submitted", id: ticketId }),
    };

  } catch (error) {
    console.error(error);
    return { statusCode: 500, body: JSON.stringify({ error: error.message }) };
  }
};