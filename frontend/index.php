<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Reporter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>🚨 Report an Incident</h1>
        
        <form id="reportForm">
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" id="name" required placeholder="John Doe">
            </div>

            <div class="form-group">
                <label>Issue Type</label>
                <select id="type">
                    <option value="Downtime">Website Down</option>
                    <option value="Slow Performance">Slow Performance</option>
                    <option value="Bug">Visual Bug</option>
                    <option value="Security">Security Issue</option>
                </select>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea id="desc" required placeholder="Describe what happened..."></textarea>
            </div>

            <button type="submit">Submit Report</button>
        </form>

        <div id="responseMessage" class="hidden"></div>
    </div>

    <script>
        document.getElementById('reportForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.querySelector('button');
            const msg = document.getElementById('responseMessage');
            
            btn.disabled = true;
            btn.innerText = "Sending...";

            // REPLACE WITH YOUR NEW FUNCTION URL
            const apiUrl = "https://ng3afpmbkrpp5huccrwh7almza0lotyd.lambda-url.ap-southeast-2.on.aws/";

            const data = {
                reporter_name: document.getElementById('name').value,
                issue_type: document.getElementById('type').value,
                description: document.getElementById('desc').value
            };

            try {
                const res = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                
                const result = await res.json();
                
                if (res.ok) {
                    msg.innerHTML = `✅ Ticket Created! ID: <strong>${result.id}</strong>`;
                    msg.className = "success";
                    document.getElementById('reportForm').reset();
                } else {
                    throw new Error(result.error || "Failed to send");
                }
            } catch (err) {
                msg.innerText = "❌ Error: " + err.message;
                msg.className = "error";
            }
            btn.disabled = false;
            btn.innerText = "Submit Report";
        });
    </script>
</body>
</html>