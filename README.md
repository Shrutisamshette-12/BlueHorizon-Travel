# BlueHorizon Travel ✈️

A travel booking website built with PHP and MySQL. Visitors can explore six destinations, book a trip, download a receipt, and chat with an AI travel assistant. Admins can log in to manage bookings.

## Features

- **Six destination packages:** Agra, Delhi, Goa, Jaipur, Kashmir and Udaipur, each with its own page
- **User accounts:** registration and login with securely hashed passwords
- **Booking flow:** booking form, demo payment pop-up, and a printable receipt
- **Single price list:** all prices live in `packages.php`, and the server looks them up, so visitors cannot change a price
- **Admin panel:** separate admin login and dashboard
- **Contact form:** messages are sent to the owner's Gmail using PHPMailer
- **Feedback system:** after a trip, customers get an email with a feedback link and can rate the trip (1 to 5 stars) with a comment
- **AI travel assistant:** a chat widget powered by the Google Gemini API that answers questions using the real packages and prices

## Technologies

- PHP, MySQL (MariaDB)
- HTML, CSS, JavaScript
- PHPMailer (email through Gmail SMTP)
- Google Gemini API (chatbot)
- XAMPP (local server)

## Setup

1. Install [XAMPP](https://www.apachefriends.org/) and start **Apache** and **MySQL**.
2. Copy this project into `C:\xampp\htdocs\Micro_Project`.
3. Open `http://localhost/phpmyadmin`, create a database named `travel_db`, and import `database.sql`.
4. Copy `config.example.php` to `config.php` and fill in your own values:
   - `MAIL_USER` and `MAIL_PASS`: your Gmail address and a Gmail **App Password**
   - `GEMINI_API_KEY`: a free key from [Google AI Studio](https://aistudio.google.com/)
5. Open `http://localhost/Micro_Project/` in your browser.

`config.php` holds private keys and is excluded from the repository with `.gitignore`.

## Notes

- The payment step is a **demo only**. No real payment is made.
- Feedback emails are sent when a logged-in admin opens `send_feedback_mail.php`. Only finished trips that have not been emailed yet are processed.
- The large gallery video `video/jaipur3.mp4` is not included because it is over GitHub's 100 MB limit.

## Project structure

| File | Purpose |
|---|---|
| `index.php` | Home page with the package list |
| `agra.php`, `delhi.php`, `goa.php`, `jaipur.php`, `Kashmir.php`, `udaipur.php` | Destination pages |
| `packages.php` | Single source of package prices |
| `book.php`, `receipt.php` | Booking and receipt |
| `login.php`, `registration_form.php`, `logout.php` | User accounts |
| `admin_login.php`, `admin_dashboard.php` | Admin area |
| `contact.php` | Contact form |
| `feedback.php`, `send_feedback_mail.php` | Feedback system |
| `ai_chat.php`, `chatbot_widget.php` | AI assistant |

## Author

Shruti Samshette