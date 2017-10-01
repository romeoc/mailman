MailMan
=======
Simple email marketing..

Setup
=======
1. Run composer
2. Add credentials to "doctrine.local" and "plugins.global"
3. Create database schema
4. Create a username
5. Populate basic variables
6. Setup up a cron job. Connect to your server through SSH, run "crontab -e" and add the following line of code:

```
0 * * * * cd /path/to/your/installation && php public/index.php process_tasks >> cron.log
```

Main Page
---------
Manage everything from here


![Main Page](/screenshots/mailman.png?raw=true "Main Page")

Contacts
--------
Add, remove or modify contact information. You can also schedule a CSV upload which runs in background.


![Contacts](/screenshots/contact.png?raw=true "Contacts")

Lists
-----
Group your contacts in mailing lists so they can be managed more easily. You can also view who unsubscribed from your list.


![Lists](/screenshots/register.png?raw=true "Lists")

Email Templates
---------------
Write your own template with the code editor, or just upload the one you built with one of the many template builders


![Email Templates](/screenshots/manage.png?raw=true "Email Templates")

Variables
---------
Variables can be used anywhere in your email templates. This can go from links to URLs all the way to full HTML headers that can be reused. Get creative!


![Variables](/screenshots/variables2.png?raw=true "Variables")

Sending Emails
--------------
Select a template, a mailing list an a time when the emails should be sent. The above crontab is running hourly, make sure to adjust it if you need to run it more often. You can always track the status of your task and see how your contacts engaged your email.


![Schedule Tasks](/screenshots/task.png?raw=true "Schedule Tasks")
