## Task manager app for Laravel
This app was developed to experiment with creating, editing and automating cron jobs.
- Logged in users can create a task, stored in table `tasks`
    - The task has a description
    - A command line script to run
    - Cron job expression
    - An email for notifying when a task has complete
- Edit task details as per above
- Tasks ran details stored in table `tasks_results`
- Automation set up to check for tasks to run every minute
- Cache used to avoid queries every minute
- Cache is cleared if a task is edited, deleted or a new one is added
