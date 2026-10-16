/* ==========================================================
   ShareShed - all JavaScript for the website
   ----------------------------------------------------------
   Every page links to this one file in <head>, right after the CSS:
       <script src="js/script.js" defer></script>
   "defer" makes the browser wait until the whole page has loaded
   before running this file, so the buttons and forms it looks for exist.
   Some parts are only for one page (e.g. the homepage banner),
   so each part first checks that the thing it needs is actually
   on the page. If it isn't, that part simply does nothing.
   ========================================================== */


/* ---------- 1. Mobile nav menu (every page) ----------
   Simple show/hide for the mobile nav menu button */
var navToggle = document.getElementById('navToggle');
if (navToggle) {
    navToggle.addEventListener('click', function () {
        document.getElementById('navLinks').classList.toggle('open');
    });
}


/* ---------- 2. Homepage banner (index.php) ---------- */
/* Banner: every 5 seconds, hide the current photo and show the next one.
   % slides.length makes it go back to the first photo after the last. */
var slides = document.querySelectorAll('.banner-slide');
var dots = document.querySelectorAll('.banner-dot');
var current = 0;
if (slides.length > 0) {
    setInterval(function () {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (current + 1) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }, 5000);
}


/* ---------- 3. Tool Catalogue search (catalog.php) ---------- */
/* After a search, scroll smoothly to the first highlighted card.
   If nothing was found, querySelector() gives null and we do nothing. */
var foundCard = document.querySelector('.card-found');
if (foundCard) {
    foundCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
}


/* ---------- 4. Registration form checks (registration.php) ----------
   These run in the browser BEFORE the form is sent, so the user
   sees mistakes straight away under each box. They use the same
   rules as process_registration.php. The server still checks
   everything again (and does the students.txt / duplicate ID
   checks), because JavaScript can be switched off. */

/* Returns an error message for one field, or '' if it's fine. */
function checkField(id) {
    var value = document.getElementById(id).value.trim();

    if (id == 'first_name' || id == 'last_name') {
        var label = (id == 'first_name') ? 'First name' : 'Last name';
        if (value == '') return label + ' is required.';
        if (!/^[A-Za-z ]+$/.test(value)) return label + ' may only contain letters and spaces.';
    }
    if (id == 'student_id') {
        if (value == '') return 'Student ID is required.';
        if (!/^[0-9]{9}$/.test(value)) return 'Student ID must be exactly 9 digits.';
    }
    if (id == 'dob') {
        if (value == '') return 'Date of birth is required.';
    }
    if (id == 'email') {
        if (value == '') return 'Email is required.';
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return 'Please enter a valid email address.';
        /* Must be the student's own student email (Student ID + domain).
           Only checked when the Student ID box looks right. */
        var sid = document.getElementById('student_id').value.trim();
        if (/^[0-9]{9}$/.test(sid) && value.toLowerCase() != sid + '@students.swinburne.edu.my') {
            return 'Please use your own Swinburne student email: ' + sid + '@students.swinburne.edu.my';
        }
    }
    if (id == 'hometown') {
        if (value == '') return 'Hometown is required.';
    }
    if (id == 'password') {
        var pw = document.getElementById('password').value;
        if (pw == '') return 'Password is required.';
        if (!/^(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/.test(pw)) return 'Password must be at least 8 characters and include a number and a symbol.';
    }
    if (id == 'confirm_password') {
        var confirm = document.getElementById('confirm_password').value;
        if (confirm == '') return 'Please confirm your password.';
        if (confirm != document.getElementById('password').value) return 'Password and Confirm Password do not match.';
    }
    return '';
}

/* Writes the message into the box under the field and turns the
   border red (or clears both if the message is empty). */
function showError(id, message) {
    document.getElementById(id + '_error').textContent = message;
    if (message == '') {
        document.getElementById(id).classList.remove('input-error');
    } else {
        document.getElementById(id).classList.add('input-error');
    }
}

/* Only run the form code if the registration form is on this page */
var registerForm = document.getElementById('registerForm');
if (registerForm) {
    var fieldIds = ['first_name', 'last_name', 'student_id', 'dob', 'email', 'hometown', 'password', 'confirm_password'];

    /* Once a field is showing an error, re-check it on every key
       press so the red message disappears as soon as it's fixed.
       (We don't check on 'blur' - a message appearing there pushes
       the Register button down and makes the user's click miss it.) */
    for (var i = 0; i < fieldIds.length; i++) {
        document.getElementById(fieldIds[i]).addEventListener('input', function () {
            if (this.classList.contains('input-error')) {
                showError(this.id, checkField(this.id));
            }
        });
    }

    /* On submit, check every field. If any fail, stop the form
       from being sent and jump to the first problem. */
    registerForm.addEventListener('submit', function (event) {
        var firstBad = null;
        for (var i = 0; i < fieldIds.length; i++) {
            var message = checkField(fieldIds[i]);
            showError(fieldIds[i], message);
            if (message != '' && firstBad == null) {
                firstBad = fieldIds[i];
            }
        }
        if (firstBad != null) {
            event.preventDefault();
            document.getElementById(firstBad).focus();
        }
    });

    /* Reset button: empty every box and remove all error messages.
       A normal reset only puts each box back to its starting value,
       and after the server sends the form back with an error, that
       starting value is what the user typed - so it wouldn't clear.
       preventDefault() stops the normal reset and we clear it ourselves. */
    registerForm.addEventListener('reset', function (event) {
        event.preventDefault();

        for (var i = 0; i < fieldIds.length; i++) {
            document.getElementById(fieldIds[i]).value = '';
            showError(fieldIds[i], '');
        }

        // Gender goes back to the first choice (Female)
        document.getElementById('gender').selectedIndex = 0;
        document.getElementById('gender_error').textContent = '';

        // Remove the "Please fix the fields marked in red" box at the top
        var registerAlert = document.getElementById('registerAlert');
        if (registerAlert) {
            registerAlert.remove();
        }
    });
}


// ==========================================
// 5. BACK TO TOP BUTTON (every page)
// ==========================================
function initBackToTop() {
    const backToTopButton = document.getElementById('backToTop');

    if (!backToTopButton) return;

    // Show/hide button based on scroll position
    function toggleBackToTop() {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    }

    // Scroll to top function
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Event listeners
    window.addEventListener('scroll', toggleBackToTop);
    backToTopButton.addEventListener('click', scrollToTop);

    // Keyboard accessibility
    backToTopButton.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            scrollToTop();
        }
    });
}

// ===========================
// MAIN INITIALIZATION FUNCTION
// ===========================
function init() {
    initBackToTop();
}

window.onload = init;
