## Contributing
This application is written in PHP 7 with Laravel 5.1.* and uses PostgreSQL as its backend database. The goal of the application is voting. This means that the #1 priority is security, and as a result, code quality. Easier code to read is easier code to audit for errors.

Pull requests will be merged by @gsingh93 if they comply with the current admin guidelines and are reasonable. The codebase will be frozen during elections unless there is a security issue or critical bug to prevent changes from taking down the site.

### Style
Follow PSR-0, PSR-1, and PSR-4 when writing new code. Additionally, you should order `use` statements by their length. You must also fix anything StyleCI points out in your PR.
### Security
Familiarize yourself with the OWASP [Top Ten](https://www.owasp.org/index.php/Top_10_2013-Top_10) to help write secure code. Do not trust user input. If you're unsure if something could be exploited, mitigate it now and ask questions later.
