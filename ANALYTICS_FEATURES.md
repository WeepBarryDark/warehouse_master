# Document Analytics Features

## Overview

The Document Analytics page provides comprehensive data visualization and statistics for all your shipping documents (装柜装箱明细).

## 📊 Features

### 1. **Summary Statistics**
- **Total Documents**: Total number of processed shipping documents
- **Total Items**: Total number of items across all documents
- **Total Value**: Total货款 across all shipments

### 2. **Interactive Charts**

#### Model Quantity Chart (型号数量排行)
- Bar chart showing top 10 models by quantity
- Helps identify most frequently shipped products
- Color-coded for easy identification

#### Model Value Chart (型号货值排行)
- Bar chart showing top 10 models by total value
- Shows which models contribute most to revenue
- Green color scheme for monetary values

#### Category Distribution (产品分类分布)
- Doughnut chart showing product category breakdown
- Visual representation of category mix
- Interactive legend

#### Monthly Trend (月度趋势)
- Line chart showing document and item trends over the year
- Two datasets: Documents and Items
- Helps identify seasonal patterns

### 3. **Detailed Tables**

#### Model Statistics Table
Complete breakdown for each model number:
- **Occurrences**: How many times the model appears
- **Total Quantity**: Total units shipped
- **Total Value**: Total revenue
- **Weight**: Total gross weight in kg
- **Volume**: Total volume in m³

#### Category Statistics Cards
Grid view of category statistics:
- Number of items per category
- Total quantity per category
- Total value per category

## 🎨 Chart Technologies

Uses **Chart.js** and **vue-chartjs** for:
- Responsive charts that work on all screen sizes
- Smooth animations
- Interactive tooltips
- Customizable colors and styling

## 📈 Data Sources

All data is calculated from:
- `shipping_documents` table
- `shipping_items` table
- Only includes documents with `status = 'processed'`
- Scoped to the authenticated user

## 🔢 Supported Metrics

### By Model
- ES Series: ES-01, ES-02, ES-03, ES-09
- EV Series: EV-01, EV-06, EV-07, EV-09
- AQUA Series: AQUA-003
- EC Series: EC03, EC04, EC13
- Other: Moschino, etc.

### By Category
- Automatically groups items by their category field
- Handles uncategorized items

### By Time
- Monthly aggregation for current year
- Tracks document count and item count trends

## 💡 Use Cases

1. **Inventory Planning**
   - Identify best-selling models
   - Forecast future shipment needs
   - Optimize stock levels

2. **Revenue Analysis**
   - See which models generate most revenue
   - Analyze category performance
   - Track monthly trends

3. **Logistics Optimization**
   - Calculate total weight and volume
   - Plan container loading
   - Optimize shipping costs

4. **Business Intelligence**
   - Seasonal trend analysis
   - Product mix optimization
   - Strategic decision making

## 🚀 Performance

- Efficient database queries with aggregations
- Charts rendered client-side for smooth interaction
- Lazy loading for large datasets
- Indexed database columns for fast queries

## 📱 Responsive Design

- Adapts to all screen sizes
- Mobile-friendly charts
- Touch-enabled interactions
- Optimized for tablets and desktops

## 🔄 Real-time Updates

Analytics are calculated on-demand:
- Always reflects latest data
- No caching issues
- Instant updates when new documents are processed

## 🎯 Navigation

Access the analytics page via:
- Sidebar: Documents → Analytics (数据分析)
- URL: `/dashboard/documents/analytics`

## 📊 Example Insights

"Based on the last 6 months, ES-02 is your top model with 1,250 units shipped worth $45,000. Consider increasing stock levels for this model."

"Your AQUA series contributes 30% of total shipment volume but only 18% of value, suggesting potential for premium pricing."

## 🛠 Customization

Want to add more charts or metrics? Edit:
- `ShippingDocumentController@analytics` - Backend data
- `Analytics.vue` - Frontend charts and layout

---

Happy analyzing! 📈
