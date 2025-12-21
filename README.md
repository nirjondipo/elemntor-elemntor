# Elemntor Elements For Elementor

A powerful WordPress plugin that extends Elementor with custom, professional widgets and functionality. Build beautiful, responsive websites with advanced Elementor widgets designed for modern web development.

## 🚀 Features

- **Custom Elementor Widgets**: Professional, fully customizable widgets
- **Mobile Menu Widget**: Responsive slide-in mobile menu with accordion-style submenus
- **Accordion Widget**: Modern, elegant accordion with icon support and smooth animations
- **Custom Category**: All widgets organized in a dedicated "Custom Elements" category
- **Full Customization**: Complete control over colors, typography, spacing, borders, and more
- **Responsive Design**: All widgets are mobile-friendly and responsive
- **Elementor Integration**: Seamless integration with Elementor's design system

## 📦 Widgets Included

### Mobile Menu Widget
A fully customizable mobile menu widget that:
- Displays registered WordPress menus
- Slide-in animation from the right
- Accordion-style dropdown for submenus
- Light and dark mode support
- Customizable burger icon, close button, and panel styling
- Full control over colors, typography, borders, and spacing

### Accordion Widget
A modern accordion widget featuring:
- Global or per-item icon support
- Open/close icon swap functionality
- WYSIWYG content editor for each item
- Multiple items can be open simultaneously
- Customizable typography, colors, backgrounds, and padding
- Smooth animations and transitions
- Professional default design with full customization options

## 📋 Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Elementor Plugin (free or pro)

## 🔧 Installation

1. **Download the plugin**
   ```bash
   git clone https://github.com/yourusername/elemntor-elemntor.git
   ```

2. **Upload to WordPress**
   - Upload the `elemntor-elemntor` folder to `/wp-content/plugins/`
   - Or install via WordPress admin: Plugins → Add New → Upload Plugin

3. **Activate the plugin**
   - Go to Plugins in WordPress admin
   - Find "Elemntor Elements For Elementor"
   - Click "Activate"

4. **Start using**
   - Open any page in Elementor editor
   - Look for "Custom Elements" category in the widget panel
   - Drag and drop widgets to your page

## 💻 Usage

### Mobile Menu Widget

1. In Elementor editor, drag the **Mobile Menu** widget to your page
2. Select a registered WordPress menu from the dropdown
3. Customize the burger icon, panel width, colors, and styling
4. Configure light/dark mode settings
5. Adjust typography, borders, and spacing as needed

### Accordion Widget

1. Drag the **Accordion** widget to your page
2. Add accordion items using the repeater control
3. Configure global icons or set icons per item
4. Add titles and content for each item
5. Customize styling: colors, typography, spacing, borders, and more

## 🎨 Customization

All widgets support extensive customization through Elementor's native controls:

- **Colors**: Background, text, hover, active states
- **Typography**: Font family, size, weight, line height
- **Spacing**: Padding, margins, item spacing
- **Borders**: Style, width, color, radius
- **Shadows**: Box shadow controls
- **Icons**: Custom icons from Elementor icon library or custom SVG/PNG
- **Responsive**: Separate controls for mobile, tablet, and desktop

## 🏗️ Development

### File Structure

```
elemntor-elemntor/
├── assets/
│   ├── css/
│   │   ├── mobile-menu.css
│   │   └── accordion.css
│   └── js/
│       ├── mobile-menu.js
│       └── accordion.js
├── includes/
│   └── widgets/
│       ├── class-mobile-menu-widget.php
│       ├── class-accordion-widget.php
│       └── class-elemntor-widget.php
├── elemntor-elemntor.php
├── readme.txt
└── README.md
```

### Adding New Widgets

1. Create a new widget class in `includes/widgets/`
2. Extend `\Elementor\Widget_Base`
3. Register the widget in `elemntor-elemntor.php`
4. Add CSS and JS assets if needed
5. Enqueue assets in the main plugin file

## 🐛 Troubleshooting

### Styles not applying on frontend
- Clear Elementor cache: Elementor → Tools → Regenerate CSS
- Clear browser cache
- Check for CSS conflicts with theme or other plugins

### Widgets not appearing
- Ensure Elementor is installed and activated
- Check that the plugin is activated
- Look for "Custom Elements" category in Elementor widget panel

### JavaScript not working
- Ensure jQuery is loaded
- Check browser console for errors
- Verify assets are enqueued correctly

## 📝 Changelog

### 1.0.0
- Initial release
- Mobile Menu widget with slide-in animation and accordion submenus
- Accordion widget with icon support and modern design
- Custom Elements category registration
- Full Elementor integration and customization options

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This plugin is licensed under the GPLv2 or later.

```
Copyright (C) 2024 Ontario Consulting

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
```

## 🙏 Acknowledgments

- Built for Elementor page builder
- Uses WordPress and Elementor APIs
- Inspired by modern web design practices

## 📞 Support

For support, please open an issue on GitHub or contact us through our website.

---

⭐ If you find this plugin useful, please consider giving it a star on GitHub!

