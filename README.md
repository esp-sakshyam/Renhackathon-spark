# 🌾 AgroPan — Agriculture Decision Simulator for Nepal

> **"AgroPan is not a website — it's a decision engine with a calm, intelligent interface."**

AgroPan is a Nepal-focused agriculture decision & risk simulation platform. It enables farmers to **simulate crop outcomes before planting** — projecting yield, risk, and profit based on Nepal's real climate, terrain, and market data.

---

## The Problem

Nepal's 3.4 million farming households make planting decisions based on tradition, intuition, and fragmented information. When a monsoon arrives late, a crop fails, or market prices crash — the damage is already done. There is no accessible tool that lets a Nepali farmer see the probable outcome of their decision *before* they commit.

## The Solution

AgroPan is a **decision-support simulator** (not a monitoring dashboard) that:

- Models **10 major Nepali crops** with realistic yield ranges
- Covers **10 districts** across all ecological zones (Terai, Mid-Hill, High-Hill)
- Factors in **monsoon dependency**, **seasonal timing**, and **market price volatility**
- Outputs **yield projections**, **profit estimates**, **risk scores**, and **actionable recommendations**
- Runs entirely **client-side** — no backend, no login, works on any phone

---

## Design Philosophy

| Principle | Application |
|---|---|
| **Minimal & calm** | Muted earth tones, generous whitespace, no visual noise |
| **Data over decoration** | Every element communicates information, nothing is ornamental |
| **Documentary-style** | Real Nepali agriculture photography, not stock images |
| **Trustworthy** | Professional typography, policy-grade presentation |
| **Nepal-first** | Crop names in Nepali script, district-specific data, monsoon modeling |

---

## Tech Stack

| Layer | Technology |
|---|---|
| **Markup** | Semantic HTML5 |
| **Styling** | CSS3 (Custom Properties, Flexbox, Grid) |
| **Logic** | Vanilla JavaScript (ES5+ compatible) |
| **Animations** | Intersection Observer API |
| **Fonts** | Poppins, Inter, Noto Sans |
| **Dependencies** | **Zero** — no frameworks, no build tools, no npm |

---

## Folder Structure

```
agropan/
├── index.html              ← Single-page app entry point
├── css/
│   ├── variables.css       ← Design tokens (colors, spacing, type)
│   ├── base.css            ← CSS reset + element defaults
│   ├── layout.css          ← Containers, grids, navbar
│   └── components.css      ← Buttons, cards, sim panel, footer
├── js/
│   ├── animations.js       ← Scroll reveal (Intersection Observer)
│   ├── simulate.js         ← Simulation engine + crop/district data
│   └── main.js             ← Nav, form handling, result rendering
├── gallery/                ← Real Nepali agriculture photographs
├── docs/
│   └── architecture.md     ← Detailed architecture documentation
└── README.md               ← This file
```

---

## How to Run Locally

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-team/agropan.git
   cd agropan
   ```

2. **Open in browser** — no build step required
   ```bash
   # Option A: Just double-click index.html

   # Option B: Use any local server
   python -m http.server 8000
   # Then open http://localhost:8000
   ```

3. **That's it.** No `npm install`, no `.env`, no Docker. AgroPan opens instantly.

---

## Key Features

### Simulation Engine
- **10 crop profiles** — Rice, Maize, Wheat, Millet, Lentil, Mustard, Potato, Sugarcane, Tea, Cardamom (with Nepali names)
- **10 district profiles** — Each with ecological zone, yield modifier, and risk modifier
- **Season matching** — Crops planted in their optimal season get better projections; off-season planting increases risk
- **Probabilistic outputs** — Yield ranges, not single numbers; profit ranges account for price volatility

### Risk Assessment
- Color-coded risk bars (Green → Amber → Red)
- Numerical risk score (0–100)
- Contextual recommendations based on crop × district × season interaction

### UI/UX
- Mobile-first responsive design
- Scroll-reveal animations with stagger effects
- Glass-morphism navigation bar
- No page reloads — entire experience in a single page
- Accessible: ARIA labels, focus states, reduced-motion support

---

## Hackathon Pitch Summary

**AgroPan** is a decision-support simulator for Nepal's agriculture sector.

**Problem:** 3.4M Nepali farming households make high-stakes planting decisions without data. One bad season can mean food insecurity.

**Solution:** A zero-dependency, mobile-friendly simulation tool that projects yield, risk, and profit *before planting* — using Nepal-specific climate, terrain, and market data.

**Differentiation:**
- Not a monitoring dashboard — it's a **pre-decision** simulator
- Not a global tool — it's **calibrated to Nepal** (districts, monsoon patterns, local crop economics)
- Not a complex app — it runs in **any browser with zero setup**
- Not a demo — it's **production-grade**, accessible, and extensible

**Impact:** Empowers smallholder farmers to make data-backed decisions, reduces seasonal risk, and generates policy-grade agricultural insights at district level.

**Future:** Real API integration, offline PWA support, WASM agronomic models, Nepali language interface, and a policymaker dashboard.

---

## Team

Built with purpose at **Ren Hackathon Spark** — for Nepal, by people who care about Nepal's food future.

---

## License

MIT — Open source & policy-grade.

*© 2026 AgroPan*
