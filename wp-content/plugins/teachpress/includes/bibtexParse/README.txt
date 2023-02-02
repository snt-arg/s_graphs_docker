################################################
PARSEENTRIES
############
This reads the contents of a BibTeX .bib file or a PHP string and returns arrays of information representing @preamble, @string and valid BibTeX entries.

Entries may be enclosed by {...} or (...).  Fields values may be enclosed by "...", {...} or without enclosure.

FLAGS can be set:
$parse->fieldExtract;
$parse->removeDelimit;
$parse->expandMacro = FALSE/TRUE to expand macros within BibTeX entries ('#' and @string values).

If $parse->fieldExtract == TRUE (default), the $entries array using the supplied example bib.bib file will be:
Array
(
    [0] => Array
        (
            [bibtexEntryType] => article
            [bibtexCitation] => klitzing:qhe
            [author] => K. v. Klitzing and G. Dorda = "and M. Pepper
            [title] => New method for h{\i}gh mark@sirfragalot.com accuracy determination of fine structure constant based on quantized hall resistance
            [journal] => PRL
            [volume] => 45
            [pages] => 494
            [blah] => bl"ah
            [year] => 1980
        )

    [1] => Array
        (
            [bibtexEntryType] => article
            [bibtexCitation] => klitzing:nobel
            [author] => Klaus von Klitzing
            [title] => The Quantized Hall Effect
            [journal] => RMP
            [volume] => 58
            [pages] => 519
            [year] => 1986
        )
)

In other words, an array of separate BibTeX entries each one an array comprising the fields, entry type and given citation. @strings will be similarly formatted.

If $parse->fieldExtract == FALSE, the $entries array using the supplied example bib.bib file will be:
Array
(
    [0] =>  @ARTICLE{klitzing:qhe, AUTHOR="K. v. Klitzing and G. Dorda = "and M. Pepper",   TITLE="New method for h{\i}gh mark@sirfragalot.com accuracy determination of fine structure constant based on quantized hall resistance", JOURNAL=PRL,  VOLUME=  45,  PAGES=494, blah="  bl"ah   ", YEAR=1980 },
    [1] =>  @ARTICLE(klitzing:nobel, AUTHOR={Klaus von Klitzing}, TITLE="The Quantized Hall Effect",JOURNAL=RMP, VOLUME=58, PAGES=519, YEAR=1986 )
)

In other words, an array of separate BibTeX entries with no further processing. @strings will be similarly formatted.
NB - IF fieldExtract == FALSE, SETTINGS FOR expandMacro AND removeDelimit WILL HAVE NO EFFECT.

If $parse->removeDelimit == TRUE (default), all double-quotes or braces that enclose field values of BibTeX entries/strings will be removed.  Otherwise, they will be left in place.  Setting this to TRUE only has an effect if $parse->fieldExtract is TRUE.

In all cases, @preamble (from the given example bib.bib file) will be returned as:
Array
(
    [bibtexPreamble] => Blah blah blah some preamble or other r
)

Additional BibTeX macro can be supplied to the parser:
$more_macro = array("RMP" => "Rev., Mod. Phys.", "LNCS" => "Lecture Notes in Computer Science");
$parse->loadStringMacro($more_macro);

$parse->returnArrays() will then return $entries with all BibTeX macros (BibTeX file + $more_macro) expanded.


################################################
PARSECREATORS
#############
This takes a BibTeX author or editor field and splits it into the component writers returning a multidimensional array consisting of  writer arrays comprised of array(firstname(s), initials, surname).  It attempts to recognise 'et. al' or 'et. al.' and returns either FALSE or TRUE if that exists.  If the input is 'Anon', 'anon', 'Anonymous' or 'anonymous' FALSE is returned.
################################################


################################################
PARSEMONTH
#############
Split a bibtex month field into day and month components including date ranges.
	list($startMonth, $startDay, $endMonth, $endDay) = $parseMonth->init($monthField);

################################################
PARSEPAGE
#############
Split a bibtex pages field into page start and page end components.
	list($start, $end) = $parsePage->init($pagesField);