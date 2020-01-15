# picture-this
school assignment to build an Instagram clone in PHP and Javascript.

# Install
1. Clone the repo
2. Install PHP
3. Navigate to the root in the terminal and open a php server on localhost:8000 (php -S localhost:8000)
4. Open localhost:8000 in your browser.

# Testers
<a href="https://github.com/oaflindberg">Andreas Lindberg</a><br>
<a href="https://github.com/mikaelaalu">Mikaela Lundsgård</a>

# Requirements

As a user I should be able to create an account.

As a user I should be able to login.

As a user I should be able to logout.

As a user I should be able to edit my account email, password and biography.

As a user I should be able to upload a profile avatar image.

As a user I should be able to create new posts with image and description.

As a user I should be able to edit my posts.

As a user I should be able to delete my posts.

As a user I should be able to like posts.

As a user I should be able to remove likes from posts.

# Extra

As a user I'm able to comment on a post.

As a user I'm able to reply to comments.

# Code review 

1. PHP code within multiple <?php ?> tags at top of document that could be within same php tags. Line 1-7 in editpost.php for example.

2. You use rgba format colors, hex format colors and name format colors in your css files. For consistency in your files you could use one single format when using colors.

3. You sometimes leave spaces between your properties in your css-files. You can trim away the spaces for the files to look cleaner.

4. In your PHP files you seem to use mainly camelcasing and in your html you use kebab-case. This may be intentional and is more of personal preference but to keep consistent you could use the same casing for your php and html classes.

5. You could add session_destroy(); to your logout.php file so that the current session is removed when the user logs out.

6. The "send" text in the comment button cuts off in mobile. You could increase the width of the button in order for the text to fit within the button.

7. In your css you often select elements like this ".comment .show-replies-form button". To increase readability you could for example give the button a class of "show-replies-button" and use that when you select it in your css. 

8. You could remove comments like "<!-- comment input -->" from the final pushed version in your github repo to make the code look cleaner.

9. In update.php you push "not your post" to your session errors if the post user id is not the same as the session user id but you also have an else statement in your editpost.php that does the same thing: "<?php else : ?><p>Not your post</p>", line 47.

10. You can rename echoErrorsAndMessages(); to something like displayErrorsAndMessages(); to make it more readable for someone not familiar with PHP and its syntax.

11. This was super difficult to review! Great job!