# SCRUD_PHP
 
# User Management System

This project is a simple User Management System built using PHP and MySQL. It allows users to perform CRUD (Create, Read, Update, Delete) operations on user records. The system also includes user authentication and image upload functionality.

## Features

- **User Authentication**: Users can log in using their email and password.
- **Add User**: Admins can add new users with details such as name, email, password, gender, and profile image.
- **Edit User**: Admins can edit existing user details, including updating the profile image.
- **Delete User**: Admins can delete users, which also removes their associated profile image from the server.
- **List Users**: Admins can view a list of all users, search for users by name or email, and see their details.
- **Image Upload**: Users can upload profile images, which are stored on the server.

## Technologies Used

- **PHP**: Server-side scripting language used for backend logic.
- **MySQL**: Database used to store user information.
- **HTML/CSS**: Frontend design and layout.
- **JavaScript**: Basic client-side interactions.

## File Structure

- **add.php**: Handles adding new users to the database.
- **delete.php**: Handles deleting users from the database and removing their profile images.
- **edit.php**: Handles editing existing user details.
- **list.php**: Displays a list of all users and allows searching.
- **login.php**: Handles user authentication and login.
- **user.php**: Show user profile page.
- **style/**: Contains CSS files for styling the application.

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/user-management-system.git
