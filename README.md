# ShareShed — COS30020 Assignment 1

A tool-lending library for Swinburne students (Student Village residents
and those living nearby): browse a tool catalogue, book repair/garden
workshops, search a tutorial library, and see what the community has
fixed or built.

## Code style note

Every page in this version is fully self-contained: the full
`<!DOCTYPE html>`, `<head>`, navigation bar and footer are written out
directly in each `.php` file, with PHP mixed in inline using
`<?php ... ?>` blocks — the same pattern as the labs (see `daysarray.php`,
`iseven.php`). Nothing about the page's HTML structure is hidden inside a
function.

The only file that isn't a page is `functions.php`. It holds plain PHP
logic every page needs — reading/writing the text-file data, and
checking whether someone is logged in — the same way you'd reuse a
built-in function like `round()` instead of retyping the rounding
formula every time. It does not print any HTML.

## How to run it

1. Copy this whole `COS30020` folder into `xampp/htdocs/`.
2. Start Apache from the XAMPP control panel.
3. Visit `http://localhost/COS30020/index.php`.
4. Register a new account — the first registration automatically
   creates `data/User/users.txt` (this demonstrates the brief's Req-3 on
   purpose, so no demo account is pre-seeded).
5. Log in, then try booking a workshop or updating your profile.

## Before you submit

- [ ] Replace the placeholder name / student ID / email in `profile.php`
      with your real details, and swap `img/default_avatar.svg` for a
      real photo.
- [ ] Record your demo video, upload it to YouTube as **unlisted**, and
      replace the placeholder link in `about.php`.
- [ ] Clear out any test accounts in `data/User/users.txt` before your
      final test pass.

## File structure

- All PHP/HTML files are in the project root, as required.
- `style/style.css` — shared stylesheet (this is just a normal linked
  CSS file, not something hiding page structure).
- `img/`, `profile_images/` — artwork and default avatars.
- `data/` — plain text data files.
