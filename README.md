# Source
This has been forked from the gist provided by Kevin Graham here: https://gist.github.com/KevinGraham-com/21606cbfeafbd7e92de886ad611012cd

# Why this exists
This hook exists because WHMCS has a separate user and account system, which is handy when there's one user associated with multiple accounts. However this becomes problematic when it's a 1:1 relationship and the user updates their email address either for the account or the user and expects it to be updated for the other one when it's not.

Even when it's not a 1:1 relationship and the account has multiple users, if the owner user changes the account email, typically they expect their user email to change as well.

Details in this feature request: https://requests.whmcs.com/idea/updating-the-client-account-should-also-update-the-users-email

# How to use
Upload the PHP file to your HWMCS installations includes/hooks folder and nothing more is required - it will automatically ensure that when a user email is changed, the matching account email is also changed and vice versa. It will only change the 'other' email address if they were originally matching between the user and account.