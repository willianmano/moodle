<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * CLI script to purge caches without asking for confirmation.
 *
 * @package    core
 * @subpackage cli
 * @copyright  2011 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/clilib.php');

// Define the input options.
$longparams = array(
    'help' => false,
    'themesonly' => false
);

$shortparams = array(
    'h' => 'help',
    't' => 'themesonly'
);

// now get cli options
list($options, $unrecognized) = cli_get_params($longparams, $shortparams);

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized), 2);
}

if ($options['help']) {
    $help =
"Invalidates Moodle internal caches

Options:
-h, --help            Print out this help
-t, --themesonly      purge only the cache themes

Example:
\$sudo -u www-data /usr/bin/php admin/cli/purge_caches.php
\$sudo -u www-data /usr/bin/php admin/cli/purge_caches.php --themesonly
";

    echo $help;
    exit(0);
}

if ($options['themesonly']) {
    echo "Purging only the theme caches\n";

    theme_reset_all_caches();

    exit(0);
}

echo "Purging all Moodle caches\n";

purge_all_caches();

exit(0);
