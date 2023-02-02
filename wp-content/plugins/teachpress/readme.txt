=== teachPress ===
Contributors: Michael Winkler
Tags: publications, enrollments, education, courses, BibTeX, bibliography
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 3.9
Tested up to: 6.2
Requires PHP: 7.0
Stable tag: 8.1.11

Manage your courses and publications with teachPress 

== Description ==
This plugin unites a course management system (with modules for enrollments, documents and assessments) and a powerful BibTeX compatible publication management. Both modules can be operated independently. teachPress is optimized for the needs of professorships and research groups. You can use it with WordPress 3.9.0 or higher.

= Features: =
* BibTeX compatible multi user publication management
* BibTeX import for publications
* BibTeX and RTF export for publications
* Direct data import from NCBI PubMed 
* RSS feed for publications
* Course management with integrated modules for enrollments, assessments and documents
* XLS/CSV export for course lists
* Many shortcodes for an easy using of publication lists, publication searches, enrollments and course overviews
* Dymamic meta data system for courses, students and publications

= Supported Languages =
* English
* German
* French (o)
* Italian (o)
* Portuguese (Brazil) (o)
* Slovak (o)
* Slovenian (o)
* Spanish (o)

(o) Incomplete language files

= Start with teachPress =
The following article describes the fist steps for [starting with teachPress](https://github.com/winkm89/teachPress/wiki/Start-with-teachPress).

= Further information = 
* [Wiki/Documentation](https://github.com/winkm89/teachPress/wiki) 
* [teachPress on GitHub](https://github.com/winkm89/teachPress)  
* [Developer blog](https://mtrv.wordpress.com/teachpress/) 

== Screenshots ==
1. Publication overview screen
2. Add publication screen
3. Add course screen
4. Single course menu
5. Example for a publication list created with [tpcloud]

== Frequently Asked Questions ==

= How can I find the documentation for the shortcodes? =
All parameters of the shortcodes are described in the [teachPress shortcode reference](https://github.com/winkm89/teachPress/wiki#shortcodes)

= How can I hide the tags, when I use the [tpcloud] shortcode? =
Use the shortcode with the following parameters: [tp_cloud show_tags_as="none"]

= How can I display images in publication lists? =
An example: [tplist image="left" image_size="70"]. Important: You must specify both image parameters.

= How can I add longer course desciptions? =
Write a long course desciption as normal WordPress pages and add this page as related content to the course.

= How can I protect course documents? =
The plugin saves course documents in your WordPress upload directory under /teachpress/*course_id*. You can add a protection for this directory with a .htaccess file without influence to your normal media files.

[More FAQs are available on GitHub](https://github.com/winkm89/teachPress/wiki/FAQ)

== Credits ==

Copyright 2008-2023 by Michael Winkler

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

= Licence information of external resources =
* Wikindx bibtex import classes (bibtexParse) by Mark Grimshaw-Aagaard & Stéphane Aulery (Licence: ISC License)
* Font Awesome Free 5.10.1 by fontawesome (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License)
* Academicons 1.8.6 by James Walsh (Font: SIL OFL 1.1, CSS: MIT License)
* jquery-ui-icons.png by The jQuery Foundation (License: MIT)

= Translators who did a great job in translating the plugin into other languages. Thank you! =
* Alexandre Touzet (French)
* Alfonso Montejo Ráez (Spanish)
* Marcus Tavares (Portuguese-Brazil)
* [Jozef Dobos] (http://xn--dobo-j6a.eu/) (Slovak)
* Elisabetta Mancini (Italian)

= Disclaimer =  
Use at your own risk. No warranty expressed or implied is provided.  

== Installation ==

1. Download the plugin.
2. Extract all the files. 
3. Upload everything (keeping the directory structure) to your plugins directory.
4. Activate the plugin through the 'plugins' menu in WordPress.

**For updates:**

1. Download the plugin.
2. Delete all files in the 'plugins/teachpress/' directory.
3. Upload all files to the 'plugins/teachpress/' directory.
4. Go in the backend to Courses->Settings and click on "Update to ....".

== Upgrade Notice ==

= 8.0.0 =
Please note that custom publication templates now requires the method get_image()!

= 6.0.1 =
Please note the [teachPress 6.0 Upgrade Information](https://mtrv.wordpress.com/2016/12/30/teachpress-6-0-upgrade-information/)

== Changelog ==

= 8.1.11 (16.01.2023) =
* Bugfix: Fix possible security issue in course system backend

= 8.1.9 (16.01.2023) =
* Bugfix: Security fix for CVE-2023-22704

= 8.1.8 (08.11.2022) =
* Bugfix: [tpcloud]: pulldown menu for tags doesn't work (#207)

= 8.1.7 (23.08.2022) =
* Bugfix: Fixed Warning: Undefined array key "" (#201)

= 8.1.6 (17.08.2022) =
* New. [tpcloud, tpsearch]: Custom select fields can now be displayed as filters out of the box! Example (field with the ID tp_meta_pub_lang): [tpsearch custom_filter="tp_meta_pub_lang" custom_filter_label="My Label"]
* New: Flexible position of the search button for pub lists added
* New: Display error messages why publications could not be imported or added

= 8.1.5 (06.03.2022) =
* Changed: Add comment field to field list in SQL statement
* Bugfix: Bugfix: Call to a member function get_ref() on null
* Bugfix: Fix undefined variable warning
* Bugfix: Add issue as default field for new publication

= 8.1.4 (08.02.2022) =
* Bugfix: Fix a variable declaration to block-scoped in teachpress_pub_showhide()

= 8.1.3 (07.02.2022) =
* New: Accept several tgid as $_GET input for a publication list (#191)

= 8.1.2 (30.01.2022) = 
* New: Issue is available as new field for journals
* Changed: New style of volume/number/issue fields in publication entries. We switch from 8(3) to vol. 8, no. 3
* Changed: Show date instead of year in publication import if it's available
* Bugfix: Fix some problems with pagination and losing filter values in the backend publications overview
* Note: Considering that 99,9% of all users using the publication management only, I've decided to split the course system from the publication management during this year. So teachPress will be a publication management only plugin in future.

= 8.1.1 (23.01.2022) = 
* New: Consider annote fields in the bibtex import and save it as comments
* Changed: Increase max size for bibtex keys from 50 to 100 chars
* Changed: Larger input fields for series, bibtex_key, crossref
* Bugfix: Set ROW_FORMAT=DYNAMIC for the tables teachpress_pub, teachpress_author, teachpress_tags during installation to fix installation problems

= 8.1.0 (29.11.2021) = 
* New: Bookmarks can be added/deleted to all users without restriction (#181)
* New: Publication type added: working paper (#184)
* New: Sort options for show authors screen added
* New: Occurence = 0 filter for authors and tags screen added
* Changed: Load plugins language files first instead of files from WP languages directory (#189)
* Changed: Using slimselect for tag selection in add/edit publication screens
* Changed: Using slimselect for bookmark selection in add/edit publication screens
* Changed: Add style info for close buttons to publication templates
* Changed: Add version info to publication template css
* Bugfix: Add font-size for abstracts and adjust font-sizes (#177)
* Bugfix: Fix display issue for bibtex entries in publication lists (#177)
* Bugfix: Fix escaping of special bibtex characters (#187) (Thanks to Lars Reimann)
* Bugfix: Add textquoteright and textquoteleft to bibtex conversion (#179)
* Bugfix: Missing "&" conversion while exporting to bibtex (#186)
* Bugfix: Fix some missing char conversions for bibtex field values in get_single_publication_bibtex()
* Bugfix: Fix items per page option in show authors screen (#190)
* Bugfix: Fix a date detection error in pubmed import

= 8.0.2 (31.08.2021) = 
* Changed: Don't longer use full table select for count queries in TP_Publications::get_publications()
* Bugfix: year field was not used fo bibtex import if date field was missing
* Bugfix: Optimize bibtex key generation within unique bibtex key check 

= 8.0.1 (26.08.2021) =
* New: [tpcloud, tplist, tpsearch]: "plain" option added for "show_tags_as" parameter. This display tags for each publications without links and filter

= 8.0.0 (15.08.2021) =
* New: New default publication template teachPress 2021 added (mobile friendly flexible layout) (#161)
* New: Flexible publication type registration added (#150)
* New: Multi value publication filters for the backend added (#148)
* New: Publication import: Option for direct import over NCBI PubMed API added (#168) (Thanks to Johan Hattne)
* New: Publication import: Option for ignoring tags added (#101) 
* New: Publication types added: media (#110), bachelor and diploma thesis (#160)
* New: DOI-Link to feedlist added (#158)
* New: [tplist, tpcloud, tpsearch]: author_name option "short" added (#171)
* New: For custom templates: Add the ability to disable (or customize) currently hardcoded text (#164)
* New: API: meta_key_search option for TP_Publications::get_publications() added (#169)
* New: API: bibtex key search option for TP_Publications::get_publications() added (#174)
* Changed: Update bibtexParse to v2.5 (#147)
* Changed: Font sizes in publication templates defined in rem
* Changed: Remove field requirements (tags, bibtex key) for adding publications (#159)
* Changed: Sort publication types in select menus after their localization name instead of the type key (#162)
* Changed: Class names follows WordPress Naming Conventions. Example: tp_publication_template is now TP_Publication_Template
* Changed: For custom templates: get_image() method for publication templates added (and is required for all templates!) (#161)
* Changed: For custom templates: $interface->get_tag_line() renames to $interface->get_menu_line()
* Changed: A fix for an old name bug changes "capabilites" to "capabilities" over the whole plugin including database tables
* Bugfix: Punctation lost after import publications (#145)
* Bugfix: BibTeX import: Uninitialized string offset: 0 notice if bibtex entries are separated with empty lines (#163)
* Bugfix: BibTeX import: Undefined index: author notice if the author field is not set (#163)

= 7.1.6 (02.05.2021) =
* Changed: Update for french language files (Thanks to Frederic Connes) (#166)

= 7.1.5 (27.04.2021) =
* Bugfix: Fixed a bug in the unique bibtex key check, which is used if a publication is added by the importer (#101)

= 7.1.4 (27.02.2021) = 
* Bugfix: Options for metadata fields not visible (#152)
* Bugfix: Replace deprecated (PHP 7.4+) syntax in PARSEENTRIES.php (#144) (Thanks to yanus)

= 7.1.3 (04.11.2020) = 
* Bugfix: Adding image URL no longer working with WordPress 5.5

= 7.1.2 (03.11.2020) =
* Changed: Migrate to newer jQuery versions: Replace jQuery .live() calls with .on()

= 7.1.1 (13.09.2020) =
* Changed: Consider note field in the publication search (#140)
* Changed: Optimize function tp_frontend_scripts (#138)
* Changed: [tpsearch]: New style for search button 
* Bugfix: Filter of tpcloud not working with non-Latin slugs (#134)
* Bugfix: Publication pages tpsearch author=(1,2,3) only returning 1st author (#142)

= 7.1.0 (25.04.2020) =
* New: image target (none, self, related post, external) and external image target URL can be defined for each publication
* Changed: [tpcloud, tplist, tpsearch]: Changed behavior for parameter "image_link". Local image target settings in each publication are priorised now
* Bugfix: Fix link icon padding in template "tp_template_orig_s" and "tp_template_orig"

= 7.0.3 (19.04.2020) =
* Bugfix: Fixed the pagination for [tpsearch] (#128)

= 7.0.2 (04.01.2020) =
* Bugfix: Fixed the visible "Show all" link for [tplist]

= 7.0.1 (02.12.2019) =
* Bugfix: [tpcloud], [tplist], [tpsearch]: Fix multiple missing default parameters

= 7.0.0 (23.11.2019) =
* New: Extra icons for URL/Files in the publication overview (#118) (Thanks to Sven Mayer)
* New: Font Awesome Fonts added (#118)
* New: Academicons Font added (#118)
* New: Menu position is now editable via TEACHPRESS_MENU_POSITION constant (#122)
* New: Various index columns for most of the database tables added (#123)
* New: Default templates: publication type as tr-class element for each entry added (#124)
* New: Label for forthcoming publications in the backend view added
* New: [tpcloud] New parameters "show_tags_as", "show_author_filter", "show_type_filter", "show_user_filter", "show_year_filter" added.
* Changed: [tpcloud], [tpsearch] and [tplist] using one common interface.
* Changed: [tpsearch]: The shortcode displays publications now by default. Can be turned off with the parameter use_as_filter="0"
* Changed: Mimetype icons removed 
* Changed: [tpsearch]: Parameter "as_filter" is replaced with "use_as_filter".
* Bugfix: Rename form fields for publications
* Bugfix: Fix problem with not escaped authors in JavaScript on add-publication.php
* Bugfix: Fix "A variable mismatch has been detected." error on add-publication.php
* Bugfix: Fix missing output from tp_bibtex_import::parse_month()
* Bugfix: Fix missing design for disabled last page button in page menus
* Bugfix: Fix styling of disabled tablenav buttons in all shortcodes
* Bugfix: [tp_cloud show_tags_as="none"] doesn't hide the tag line of each publication (#107)
* Bugfix: Missing keywords in the bibtex output of the cite function
* Bugfix: [tpcloud, tplist, tpsearch]: Fix colspan for headline rows in the publication list

= 6.2.5 (07.04.2019) =
* New: [tplist]: HTML anchor added
* Changed: Handling of [tplist] shortcodes which are used multiple times in one post/page
* Changed: "Deleted" message for course terms and types in the settings added
* Changed: Overwrite publication option for the importer is now an update option 
* Bugfix: Buttons for 'next/last page' of [tplist] are not visible in responsive design (#109)
* Bugfix: bibtexParse class uses removed function split (#111)
* Bugfix: Fix array offset errors in bibtexParse class PARSEENTRIES::get_line()

= 6.2.4 (10.04.2018) =
* Changed: Requirement for PHP 5.3+ added
* Bugfix: Descending numeration starts with 0, if pagination is disabled in the shortcodes
* Bugfix: [tpsearch]: Descending numeration doesn't work
* Bugfix: Widget init uses deprecated PHP function (#97)

= 6.2.3 (11.03.2018) = 
* New: [tpcloud]: New parameter "show_type_filter" added
* New: New method has_tag() for publication templates

= 6.2.2 (04.03.2018) = 
* New: [tpcloud]: New parameter "show_in_author_filter" added (#95)
* New: Publications import: Added handling for bibtech special chars {\aa}, {\AA},'{\O}','{\o}' (Thanks to Thomas Grah)
* Bugfix: [tpcloud, tplist]: "exclude_types" parameter doesn't work with more than one value (#94)
* Bugfix: [tpcloud, tplist, tpsearch] Fix for the numeration of publications (#91)

= 6.2.1 - (02.01.2018) =
* New: [tpcloud]: New parameter "show_author_filter" (#89)
* New: [tpcloud]: New parameter "show_user_filter" (#90)
* Changed: Limit number of items in RSS feeds (#86)
* Changed: Wrap description of publications in RSS feed in CDATA blocks (#87)
* Bigfix: Fix a compatibility problem with PHP 5.3 or lower (#88, #72)

= 6.2.0 - (22.11.2017) =
* New: Ajax based bibtex key generator (#70)
* New: [tplist, tpcloud]: New parameter "exclude_types" (#75)
* New: DOI url resolver is now editable through constant TEACHPRESS_DOI_RESOLVER (#72)
* New: publication type "workshop" added (#67)
* New: Add "show_link" option for [tpref] shortcode (experimental feature)
* Bugfix: DOI included in URL list (Thanks to Sven Mayer) (#73)
* Bugfix: Infinte loop when using headlines grouped by year and then by type (headline="4") (Thanks to Abel Gómez) (#76)
* Bugfix: Wrong quote characters cause invalid generation of LaTeX accented letters (Thanks to Abel Gómez) (#77)
* Bugfix: Enable title links in inline mode if DOI is available (Thanks to Abel Gómez)  (#78)
* Bugfix: Booktitle column is too small for some publications (#80)
* Bugfix: Division through zero error in shortcodes.php (#82)
* Bugfix: Fix substitutions in convert_bibtex_functions (#83)
* Bugfix: Prevent double encodes in tags (#84)

= 6.1.0 - (14.08.2017) =
* New: List of imports is now availabe
* New: Support for returning meta data to get_publications() added (#61)
* New: [tplist, tpcloud]: New parameter "include_editor_as_author" added (#62)
* Changed: "Dynamic detection" is now the default option for author/editor detection in the publication import
* Changed: Foreign key constraints for new installations removed
* Bugfix: Fixed editor parsing in the publication import
* Bugfix: Fixed problems with some special chars in the publication import for author/editor names

= 6.0.4 - (14.05.2017) =
* New: Publication type "patent" added (#59)
* New: [tpcloud, tplist, tpsearch]: New parameters "author_separator" and "editor_separator" added (#58)
* Changed: [tpcloud]: "nofollow" attributes for tag links added
* Changed: [tpcloud]: URL values in jump menus splitted
* Changed: Expansion for special chars which will be detected during the import
* Bugfix: Fix for displaying editors as authors for periodical in RTF and text exports
* Bugfix: [tpcloud]: Fix align setting for the "show all" button
* Bugfix: [tpsingle]: Fix for displaying editors as authors for collections and periodical
* Bugfix: [template: teachPress original small]: Remove annoying extra space in bibliographic template (#54)
* Bugfix: [template: teachPress original small]: Years were displayed twice in publication lists (#10)
* Bugfix: Fixed missing tables in tp_tables::remove()

= 6.0.3 - (17.02.2017) =
* Bugfix: [tpsearch]: Fixed a PHP warning which occurs if "as_filter" is enabled.

= 6.0.2 - (22.01.2017) =
* Bugfix: UTF-8 to TeX conversion fixed for é/è and É/È (Thanks to Marcel Waldvogel) (#51)
* Bugfix: Variable initialization fixed for better PHP 7.1 compatibility (Thanks to Marcel Waldvogel) (#50)
* Bugfix: Enable german translation of "inproceedings" in singular

= 6.0.1 - (14.01.2017) =
* Bugfix: [tpcloud, tplist, tpsearch]: Fixed a problem which can lead to PHP fatal errors while generating publication lists (#49)

= 6.0.0 - (30.12.2016) =
* New: Template system for publication lists added (#26)
* New: Cite function for publications in the backend (#22)
* New: Option for dynamic author/editor format detection for bibtex imports added (#15)
* New: System for replacing BibTeX journal macros added (#46)
* New: [tpenrollments]: New parameter "order_signups" added
* New: [tpcloud]: New parameter "year" added (#34)
* New: [tpcloud, tplist, tpsearch]: New parameter "template" added (#26)
* New: [tpcloud, tplist, tpsearch]: New parameter "image_link" added (#8)
* New: [tpcloud, tplist, tpsearch]: New parameter "title_ref" added (#14)
* New: [tpcloud, tplist, tpsearch]: New parameter "show_bibtex" added (#12)
* New: [tpcloud, tplist]: Altmetric support added; New parameters: "show_altmetric_donut", "show_altmetric_entry" (#44)
* New: Colored labels for publication types added (with the new template) (#13)
* New: Option to mark publications as "forthcoming"
* New: Altmetric support added (not avaiable by default)
* Changed: RSS feeds, bibtex feeds, export streams and ajax requests now generated via WordPress APIs (#35)
* Changed: [tplist, tpcloud]: Parameter "entries_per_page" works now if pagination is disabled (#20)
* Changed: [tplist, tpcloud, tpsearch]: Default settings for author/editor name parsing changed to initials (#19)
* Changed: [tplist, tpcloud, tpsearch]: Usage of parameter "style" changed (#26)
* Changed: [tpcloud]: Show filters (year, type, authors, user) if more than one value is given via parameters (#33)
* Changed: Style improvements for better support for WordPress 4.4+
* Bugfix: Fixed the problem with including wp-load.php for generating feeds and exports (#35)
* Bugfix: Fixed a bug in the tinyMCE plugin which leads to wrong default parameters for [tplist]
* Bugfix: Fixed a optical sort order problem with assessments
* Bugfix: Inproceeding renamed to Inproceedings because the singular form doesn't exist

[Older entries](https://github.com/winkm89/teachPress/wiki/Changelog)