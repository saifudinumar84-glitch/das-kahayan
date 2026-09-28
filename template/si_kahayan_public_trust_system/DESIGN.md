---
name: Si Kahayan Public Trust System
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#3f4944'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#6f7a73'
  outline-variant: '#bec9c2'
  surface-tint: '#106b4f'
  primary: '#00513a'
  on-primary: '#ffffff'
  primary-container: '#0f6b4f'
  on-primary-container: '#97e8c5'
  inverse-primary: '#86d6b4'
  secondary: '#006a6a'
  on-secondary: '#ffffff'
  secondary-container: '#8ff3f2'
  on-secondary-container: '#007070'
  tertiary: '#623f00'
  on-tertiary: '#ffffff'
  tertiary-container: '#825400'
  on-tertiary-container: '#ffcf92'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#a1f3cf'
  primary-fixed-dim: '#86d6b4'
  on-primary-fixed: '#002115'
  on-primary-fixed-variant: '#00513a'
  secondary-fixed: '#8ff3f2'
  secondary-fixed-dim: '#72d6d6'
  on-secondary-fixed: '#002020'
  on-secondary-fixed-variant: '#004f50'
  tertiary-fixed: '#ffddb4'
  tertiary-fixed-dim: '#ffb955'
  on-tertiary-fixed: '#291800'
  on-tertiary-fixed-variant: '#633f00'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  display-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 3rem
    fontWeight: '700'
    lineHeight: 3.5rem
  display-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 2.25rem
    fontWeight: '700'
    lineHeight: 2.75rem
  headline-xl:
    fontFamily: Plus Jakarta Sans
    fontSize: 2rem
    fontWeight: '700'
    lineHeight: 2.5rem
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.5rem
    fontWeight: '600'
    lineHeight: 2rem
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.25rem
    fontWeight: '600'
    lineHeight: 1.75rem
  title-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 1rem
    fontWeight: '600'
    lineHeight: 1.5rem
  body-lg:
    fontFamily: Inter
    fontSize: 1.125rem
    fontWeight: '400'
    lineHeight: 1.75rem
  body-md:
    fontFamily: Inter
    fontSize: 1rem
    fontWeight: '400'
    lineHeight: 1.5rem
  body-sm:
    fontFamily: Inter
    fontSize: 0.875rem
    fontWeight: '400'
    lineHeight: 1.25rem
  label-md:
    fontFamily: Inter
    fontSize: 0.875rem
    fontWeight: '600'
    lineHeight: 1.25rem
  label-sm:
    fontFamily: Inter
    fontSize: 0.75rem
    fontWeight: '600'
    lineHeight: 1rem
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-mobile: 1rem
  margin: 2rem
  margin-mobile: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2.5rem
---

## Brand & Style
The design system embodies the standard of modern Indonesian civic technology—authoritative, accessible, and grounded in community safety. Built to serve business actors, laboratory inspectors, and citizens across Central Kalimantan, the interface balances institutional gravity with warm, accessible clarity.

The visual style combines Corporate Modern structure with subtle regional identity: crisp content surfaces, generous breathing room, high-contrast legibility, and refined geometric wave motifs referencing the flow of the Kahayan River. Every touchpoint instills confidence, communicating procedural integrity and strict regulatory compliance without appearing bureaucratic or impenetrable.

## Colors
The palette is calibrated for institutional integrity, high accessibility compliance (WCAG 2.1 AA/AAA), and unequivocal status communication.

- **Primary (`#0F6B4F`)**: Deep forest green representing health, safety, and regulatory authority. Used for prominent headers, primary action buttons, key brand navigation, and active tab indicators.
- **Secondary (`#0E8A8A`)**: Calm river teal evoking the waterways of Central Kalimantan; applied to auxiliary CTAs, active filters, subtle graphic accents, and statistical charts.
- **Accent / Warning (`#F5A623`)**: Vibrant amber designating pending queues, review states, or approaching deadlines.
- **Neutrals**:
  - `Surface canvas`: `#FFFFFF`
  - `Card / Container background`: `#F8FAFC`
  - `Border / Dividers`: `#E2E8F0`
  - `Muted labels / Placeholders`: `#64748B`
  - `High-contrast body text & titles`: `#1E293B`
- **Semantic Compliance Statuses**:
  - **Memenuhi Syarat (MS)**: Text `#0D6346` over container `#E8F5E9` with border `#A3E635`
  - **Tidak Memenuhi Syarat (TMS)**: Text `#991B1B` over container `#FEF2F2` with border `#FCA5A5`
  - **Menunggu / Menuju Tenggat**: Text `#92400E` over container `#FFFBEB` with border `#FCD34D`
  - **Dalam Proses Verifikasi**: Text `#1E40AF` over container `#EFF6FF` with border `#93C5FD`

## Typography
The typographic hierarchy balances bureaucratic credibility with citizen-first legibility:

- **Headlines (Plus Jakarta Sans)**: Used across all structural entry points, dashboards, section headers, and statistical summary callouts. Features warm geometric curves that prevent the interface from feeling sterile.
- **Body & Data Tables (Inter)**: Handles all inspection dossiers, regulatory logs, form inputs, and transactional tables. Its tall x-height and neutral geometry maximize legibility when presenting dense administrative information on low-resolution displays.
- **Numeric Alignment**: Numerical audit codes, batch numbers, and registration IDs use tabular lining figures (`font-feature-settings: 'tnum' 1`) to preserve column alignment in verification tables.

## Layout & Spacing
The layout adheres to a flexible 12-column grid on desktop screens (breakpoint 1024px+), consolidating to an 8-column layout on tablets (768px - 1023px) and a single-column / 4-column hybrid on mobile viewports (<768px).

- **Outer Margins**: Desktop layouts maintain a maximum container width of `1280px` with `2rem` outer margins. Mobile views reduce lateral padding to `1rem` to optimize screen real estate.
- **Vertical Rhythm**: Built upon an 8px grid system. Standard forms and modular card listings rely on `space-md` (`1rem`) and `space-lg` (`1.5rem`) gaps, ensuring public service dashboards remain readable without vertical clutter.

## Elevation & Depth
Depth is created through clean surface tiers layered with soft ambient shadows tinted slightly with slate and forest hues, avoiding harsh blacks:

- **Level 0 (Flat Canvas)**: Pure `#FFFFFF` base or `#F8FAFC` page backdrop with no shadow.
- **Level 1 (Card & Content Blocks)**: Raised above canvas using an ultra-subtle border (`1px solid #E2E8F0`) and ambient shadow: `0 1px 3px 0 rgba(15, 23, 42, 0.05), 0 1px 2px -1px rgba(15, 23, 42, 0.05)`.
- **Level 2 (Dropdowns, Floating Tables, Interactive Hover)**: `0 4px 6px -1px rgba(15, 23, 42, 0.08), 0 2px 4px -2px rgba(15, 23, 42, 0.05)`.
- **Level 3 (Modals & Verification Overlays)**: `0 20px 25px -5px rgba(15, 107, 79, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04)`.
- **Kahayan Wave Motif**: Section breaks and header banners feature subtle low-opacity vector linework derived from Central Kalimantan rippling water patterns, rendered at 4% opacity in `#0F6B4F` against card surfaces.

## Shapes
In accordance with Level 2 roundedness, interactive elements, containers, and badges utilize balanced, modern radii:

- **Input Fields & Buttons**: Standard `0.5rem` (`8px`) to maintain structured alignment alongside data tables.
- **Cards & Data Containers**: Extended `rounded-lg` (`1rem` / `16px`) and `12px` interior containers, conveying a friendly, contemporary government service aesthetic.
- **Pills & Status Badges**: Fully rounded radii (`9999px`) to create clear visual separation between fixed data blocks and state indicators.

## Components

- **Buttons**:
  - *Primary*: Background `#0F6B4F`, text `#FFFFFF`, rounded `8px`, font Inter SemiBold (`14px`), minimum touch target `44px`. Hover state darkens to `#0A4C38`.
  - *Secondary*: Border `1.5px solid #0E8A8A`, background transparent, text `#0E8A8A`. Hover fills with `#F0FDFA`.
  - *Tertiary / Ghost*: Text `#1E293B`, hover fills `#F1F5F9`.

- **Verification Status Badges (Chips)**:
  - Formed as pills (`rounded-full`), padding `4px 12px`, with an accompanying 6px status dot.
  - *Memenuhi Syarat (MS)*: Green dot `#0F6B4F`, background `#DCFCE7`, text `#14532D`.
  - *Tidak Memenuhi Syarat (TMS)*: Red dot `#DC2626`, background `#FEE2E2`, text `#7F1D1D`.
  - *Menunggu Hasil Lab*: Amber dot `#D97706`, background `#FEF3C7`, text `#78350F`.
  - *Dalam Proses*: Blue dot `#2563EB`, background `#DBEAFE`, text `#1E3A8A`.

- **Input Fields**:
  - Border `1px solid #CBD5E1`, background `#FFFFFF`, text `#1E293B`, rounded `8px`, height `44px`, horizontal padding `12px`.
  - Focus state: Border color `#0F6B4F`, box shadow ring `0 0 0 3px rgba(15, 107, 79, 0.15)`.

- **Cards & Inspection Dossier Containers**:
  - Surface `#FFFFFF` or `#F8FAFC`, border `1px solid #E2E8F0`, rounded `12px`, inner padding `24px`.
  - Card headers feature a subtle left accent border (`4px solid #0F6B4F` or `#0E8A8A`) to immediately identify regulatory categories.

- **Checkboxes & Radios**:
  - Dimensions `18px x 18px`, border `1.5px solid #94A3B8`.
  - Checked state: Fill `#0F6B4F`, white checkmark or center pip, transition `150ms ease-in-out`.

- **Sample Inspection Timeline**:
  - Step tracker showing food sample lifecycle: *Pengambilan Contoh* &rarr; *Uji Laboratorium* &rarr; *Kajian Risiko* &rarr; *Penerbitan Rekomendasi*. Complete nodes use `#0F6B4F`, active nodes pulse with `#0E8A8A`, and upcoming nodes remain `#CBD5E1`.