# Source
This has been forked from the gist provided by Kevin Graham here: https://gist.github.com/KevinGraham-com/21606cbfeafbd7e92de886ad611012cd

# Why this exists
This hook exists because WHMCS has a separate user and account system, which is handy when there's one user associated with multiple accounts. However this becomes problematic when it's a 1:1 relationship and the user updates their email address either for the account or the user and expects it to be updated for the other one when it's not.

Even when it's not a 1:1 relationship and the account has multiple users, if the owner user changes the account email, typically they expect their user email to change as well.

Details in this feature request: https://requests.whmcs.com/idea/updating-the-client-account-should-also-update-the-users-email

# How to use
Upload the PHP file to your HWMCS installations includes/hooks folder and nothing more is required - it will automatically ensure that when a user email is changed, the matching account email is also changed and vice versa. It will only change the 'other' email address if they were originally matching between the user and account.

# Security considerations
We have to assume WHMCS is only firing these hooks when the user making the changes has permissions to do so.

When doing client -> user email push, the logged in user could be a secondary user on the account that is malicious, with permissions to update the account profile info. To mitigate this, the code now validates that the current user logged in is the same as the user being updated and that they're the owner before making the email address change. This prevents secondary users from changing the owner user email address via the account.