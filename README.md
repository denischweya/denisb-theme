# Denis B theme

A block theme for [denis.swishfolio.com](https://denis.swishfolio.com/): an editorial portfolio with light and dark modes, case studies, a products catalogue and product landing pages.

Every page, section and template is edited in the block editor or the Site Editor. The theme builds no blocks of its own. Sections are made from:

- core blocks,
- [Swishfolio Core](https://github.com/denischweya/swishfolio-core) blocks,
- a few blocks from the [Denis B plugin](https://github.com/denischweya/denisb-plugin).

The design comes from block style variations, picked in each block's **Styles** panel.

Requires the Denis B and Swishfolio Core plugins, WordPress 6.7+ and PHP 8.0+.

## Templates and parts

| Template | Shows |
| --- | --- |
| `front-page` | The homepage content, then the contact band and footer |
| `single-sfcore_project` | A case study, followed by the "Next case study" link |
| `page-product` | Product pages and the `/products/` catalogue, in the products page style. Pick **Product page** under Template. |
| `page`, `single`, `index`, `404` | Plain pages and posts |

Parts: `header` (with the Products mega menu), `header-case` (with "All work"), `contact`, `footer`, `footer-case`.

## Block style variations

Registered in `functions.php` and styled in `assets/css/variations.css`.

| Block | Styles |
| --- | --- |
| Group | Hero, Case study hero, Panel, Browser window, Browser window (large), Facts grid, Fact, Link row, Align bottom, Align middle, Site header, Contact band, Site footer, Page |
| Paragraph | Label, Small label, Mono note, Availability badge, Intro, Body, Body (narrow), Long copy, Case study tagline, Section note, Tagline, Browser bar |
| Heading | Display, Featured title, Spotlight title, Section heading, Case study heading |
| Post Title | Case study title, Page title |
| Button | Lime, Dark, Outline, Black, Header button, Back link (with Swishfolio Core's button icons) |
| Image | Avatar, Scrolling screenshot, Scrolling screenshot card |
| List, Quote | Tags, Tags (mono); Inline quote, Large quote |
| Navigation, Site Title | Header links; Brand |
| Swishfolio Core Features | Numbered list, Link cards, Service cards, Built cards, Process steps |
| Swishfolio Core Portfolio, CV, Testimonials, FAQ, Links | Work list, Experience list, Quote cards, Minimal, Underlined links |

Tall screenshots in the scrolling image styles scroll on hover. `scroll.js` sets the duration from the image's height.

## theme.json

The palette points at the CSS variables in `base.css`, so the light and dark modes apply to every preset colour. The file also defines:

- the site fonts,
- the font sizes,
- the gutter and section spacing presets used for grid gaps and section padding.

## Styles and scripts

| File | Covers |
| --- | --- |
| `assets/css/base.css` | Colour tokens for light and dark, motion, the dog, scroll frames |
| `assets/css/variations.css` | Block style variations, and overrides that fit Swishfolio Core blocks to the design |
| `assets/css/pages.css`, `blocks.css` | Product pages and the catalogue (the `page-product` template) |
| `assets/css/mega-menu.css` | The Products mega menu |
| `assets/css/editor.css` | Editor canvas width and spacing |
| `assets/js/motion.js` | Scroll reveals, the custom cursor and the dog on the homepage and case studies. All of it respects `prefers-reduced-motion`. |
| `assets/js/scroll.js` | Scrolling screenshots on hover, on every page |
| `assets/js/rotate.js` | Rotating headline words (the plugin's **Rotating words** format) |

## License

GPL-2.0-or-later. Fonts load from Google Fonts: Geist, Geist Mono, Bebas Neue and Instrument Serif, under the SIL Open Font License.
