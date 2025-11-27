# 🚨 Serverless Incident Reporter

**A Cloud-Native Ticketing System utilizing AWS Lambda, DynamoDB, and SNS.**

This project demonstrates a secure, serverless architecture for handling user data. It captures incident reports via a PHP frontend, processes them through an AWS Lambda backend, persists them in a NoSQL database, and triggers real-time email alerts to administrators.

## 📸 Project Visuals

### 1. The Dashboard (PHP Frontend)
*A responsive form handling POST requests with CORS security integration.*
![Dashboard Interface](dashboard.png)

### 2. Real-Time Alerting (AWS SNS)
*Automatic email notification triggered immediately upon ticket submission.*
![Email Notification](email.png)

### 3. Data Persistence (AWS DynamoDB)
*NoSQL record storage with unique UUIDs and timestamp logging.*
![Database Record](dynamodb.png)

## 🚀 Key Features
* **Event-Driven Backend:** Uses **AWS Lambda (Node.js 20.x)** to process incoming POST requests securely.
* **NoSQL Persistence:** Stores every incident ticket in **AWS DynamoDB** with a generated UUID.
* **Real-Time Alerting:** Immediately dispatches an email notification to admins via **AWS SNS** when a new ticket is created.
* **Security:** Implements custom **CORS** policies to allow secure communication between the frontend and the cloud API.
* **Infrastructure as Code:** Fully automated deployment via **GitHub Actions** (CI/CD).

## 🏗 Architecture
The data flows securely from the client to the cloud without managing a single server:

`User Form (PHP)` → `POST Request` → `AWS Lambda`
                                         ↓
                                -------------------
                                ↓                 ↓
                           `DynamoDB`           `SNS`
                          (Save Data)       (Email Alert)

## 🛠 Tech Stack
| Component | Technology | Role |
| :--- | :--- | :--- |
| **Backend** | AWS Lambda (Node.js) | Serverless Compute Logic |
| **Database** | AWS DynamoDB | NoSQL Data Store |
| **Alerting** | AWS SNS | Notification Service |
| **Frontend** | PHP 8.x + Fetch API | User Interface |
| **DevOps** | GitHub Actions | Automated Deployment |

## 🔧 Technical Challenges Solved
1.  **CORS & Security:** Configured Lambda Function URLs to strictly handle cross-origin `POST` requests from the frontend application.
2.  **Data Validation:** Implemented backend logic to validate user input before processing to prevent database corruption.
3.  **Async Processing:** Designed the system to perform database writes and email notifications in parallel execution.

## 🚀 How to Run Locally
1.  Clone the repository.
2.  Navigate to the frontend folder.
3.  Start the PHP server:
    ```bash
    php -S localhost:8000
    ```
4.  Open `http://localhost:8000`.

---
*Built by Joriel Espinocilla as part of a Cloud Engineering Portfolio.*