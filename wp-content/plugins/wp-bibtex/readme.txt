=== Plugin Name ===
Contributors: zjhzxhz
Donate link: https://haozhexie.com/
Tags: BibTeX, citation, paper
Requires at least: 3.0.1
Tested up to: 6.1
Stable tag: 2.2.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A plugin helps format BibTeX entries to display a bibliography or cite papers in WordPress.

== Description ==

The plugin generates bibiography style text of a citation with provided infomration. 

Here's an example. Please paste following shortcode in a page.

`[WpBibTeX type="article" title="Comparison among dimensionality reduction techniques based on Random Projection for cancer classification" author="Xie, Haozhe and Li, Jie and Zhang, Qiaosheng and Wang, Yadong" journal="Computational biology and chemistry" year="2016" pages="165--172"  publisher="Elsevier" volume="65" url="//infinitescript.com/wordpress/wp-content/uploads/publications/xie2016comparison.pdf" note="(IF=1.014)"]`

And the shortcode above will generate following contents in a page:

- The bibiography style text of this citation: `Haozhe Xie, Jie Li, Qiaosheng Zhang, Yadong Wang. Comparison among dimensionality reduction techniques based on Random Projection for cancer classification. Computational biology and chemistry, 65: 165-172, 2016. (IF=1.014)`
- The BibTeX cite code: 

`@article{xie2016comparison,
  title={Comparison among dimensionality reduction techniques based on Random Projection for cancer classification},
  author={Xie, Haozhe and Li, Jie and Zhang, Qiaosheng and Wang, Yadong},
  journal={Computational biology and chemistry},
  year={2016},
  volume={65},
  pages={165--172}
}`

**New Features in 2.x**

**In addition**, you can also customize links diaplayed in the page. By default, there're two links (`[BibTeX]` and `[Download PDF]`) for each citation. Now, you can add customized links in option page.

Suppose you create a new field whose `Field Key` is `code` and `Field Name` is `Download Code`. Then you will use `code` attribute in the `[WpBibTeX]` shortcode as following:

`[WpBibTeX type="article" ... code="https://link/to/the/code"]`

In this page, a new link `[Download Code]` will be displayed after `[BibTeX]` link.

**Supported BibTeX Entry Types**

Currently, this plugin support following BibTeX entries types:

*article*

- **Required fields:** `type`, `title`, `author`, `journal`, `year`
- **Optional fields:** `volume`, `number`, `pages`, `month`, `publisher`, `url`, `note`
- **Short code example:** `[WpBibTeX type="article" title="Title of the citation" author="First Name1, Last Name1 and First Name2, Last Name2 and First Name3, Last Name3" journal="Journal Name of the citation" year="2016" volumne="1" url="The download link of the article" note="(IF=1.000)"]`

*book*

- **Required fields:** `type`, `title`, `author`, `publisher`, `year`
- **Optional fields:** `volume`, `number`, `series`, `edition`, `month`, `address`, `isbn`, `url`, `note`
- **Short code example:** `[WpBibTeX type="book" title="Title of the citation" author="First Name1, Last Name1 and First Name2, Last Name2 and First Name3, Last Name3" publisher="Publisher of the citation" year="2016" address="The address of the publisher" url="The download link of the article"]`

*inproceedings*

- **Required fields:** `title`, `author`, `booktitle`, `year`
- **Optional fields:** `volume`, `number`, `series`, `pages`, `month`, `organization`, `publisher`, `address`, `url`, `note`
- **Short code example:** `[WpBibTeX type="inproceedings" title="Title of the citation" author="First Name1, Last Name1 and First Name2, Last Name2 and First Name3, Last Name3" booktitle="The name of the conference, such as CVPR" address="The address of the publisher" year="2016" note='<span style="color: red">write anything you want</span>']`

*mastersthesis*

- **Required fields:** `title`, `author`, `school`, `year`
- **Optional fields:** `month`, `address`, `url`, `note`
- **Short code example:** `[WpBibTeX type="mastersthesis" title="Title of the citation" author="First Name1, Last Name1" school="The place where the citation was written" year="2016"]`

*phdthesis*

- **Required fields:** `title`, `author`, `school`, `year`
- **Optional fields:** `month`, `address`, `url`, `note`
- **Short code example:** `[WpBibTeX type="phdthesis" title="Title of the citation" author="First Name1, Last Name1" school="The place where the citation was written" year="2016"]`

*unpublished*

- **Required fields:** `title`, `author`
- **Optional fields:** `month`, `year`, `url`, `note`
- **Short code example:** `[WpBibTeX type="unpublished" title="Title of the citation" author="First Name1, Last Name1"]`

== Installation ==

1. Upload `WP-BibTeX` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enjoy!

== Frequently Asked Questions ==

1. Who need this plugin?

Researchers who need to display their publications in their homepage can use this plugin to manage and list their works easier.

== Screenshots ==

1. Output Preview
2. Options Page

== Changelog ==

= 2.2.7 =
* Fix some bugs that cause WordPress fatal errors.

= 2.2.6 =
* Fix the bug when generating Ph.D. thesis BibTeX items.

= 2.2.5 =
* Fix some bugs.

= 2.2.4 =
* Support arXiv publications.

= 2.2.3 =
* Fix bugs causing update failed.

= 2.2.2 =
* Open link in a new window.
* Remove `impact_factor` field for journal articles.
* Don't display `note` field in BibTeX.

= 2.2.1 =
* Fix bugs in bibliography style text.

= 2.2.0 =
* Allow use HTML tag in `note` field.

= 2.1.0 =
* Add field `note` for add custom text for citations.

= 2.0.1 =
* Fix bugs for PHP version lower than 7.

= 2.0.0 =
* Support customize fields for citations and these fields will be displayed as a link in the page.

= 1.1.0 =
* Highlight the blog owner himself/herself in bibiography text.

= 1.0.0 =
* Complete basic function for convert citation information to BibTex and bibiography style text.
