# Denis B theme

The WordPress version of [denis.swishfolio.com](https://denis.swishfolio.com/): an editorial portfolio with light and dark modes, case studies, a products catalogue and product landing pages.

It needs the [Denis B plugin](https://github.com/denischweya/denisb-plugin), which provides the content types and settings. Without the plugin, the theme still loads but shows empty sections and an admin notice.

## Templates

| Template | Shows |
| --- | --- |
| `front-page.php` | Hero, featured project, spotlight, shipped products, client work, services, process, experience, testimonials, FAQ, contact |
| `single-db_project.php` | A case study |
| `archive-db_product.php` | The `/products/` catalogue with type filters |
| `single-db_product.php` | A product landing page: the hero comes from fields, the rest from the block editor |
| `header.php`, `footer.php` | Navigation with the Products mega menu, the theme switcher and the footer |

## Styles

The theme loads only its own CSS. Core block styles and global styles are removed on the front end.

| File | Covers |
| --- | --- |
| `assets/css/site.css` | Homepage and case studies |
| `assets/css/pages.css` | Products pages |
| `assets/css/blocks.css` | Maps core block markup (buttons, groups, paragraphs, images) onto the design |
| `assets/css/mega-menu.css` | The Products menu |

The editor loads `pages.css`, `blocks.css` and `editor.css`, so product pages look the same while you edit them.

## Scripts

| File | Does |
| --- | --- |
| `theme.js` | System, light and dark switcher, saved in `localStorage` |
| `motion.js` | Rotating hero words, scroll reveals, the custom cursor and the dog. All of it respects `prefers-reduced-motion`. |
| `products.js` | Catalogue filters |

## Requirements

WordPress 6.5+, PHP 8.0+.

## License

GPL-2.0-or-later. Fonts load from Google Fonts: Geist, Geist Mono, Bebas Neue and Instrument Serif, under the SIL Open Font License.
