# ClearLagg

<img src="https://i.ibb.co.com/gW2N2Hz/OIG1-removebg-preview.png">

---

ClearLagg is a plugin for PocketMine-MP designed to reduce lag by periodically clearing dropped items in the world. It provides configurable options and commands to manage item clearing, player notifications, and detailed statistics.

## Features

- Automatic item clearing at configurable intervals
- World-specific configurations
- Player notifications before item clearing
- Command to manually clear items
- Detailed statistics of cleared items

## Installation

1. Download the latest release of ClearLagg from [Poggit](https://poggit.pmmp.io/p/clearlagg).
2. Place the downloaded `.phar` file into the `plugins` directory of your PocketMine-MP server.
3. Restart your server to load the plugin.

## Configuration

After installing the plugin, a configuration file `config.yml` will be generated in the `plugin_data/ClearLagg` directory. You can customize the settings as needed.

### Default Configuration

```yaml
# ClearLagg configuration file

# Please Don't Edit configuration ver
config-version: 3

# Time in seconds between automatic clears
clear-interval: 300

# Time interval in seconds for countdown message broadcast
broadcast-interval: 15

# World-specific settings
worlds:
  world:
    enable-auto-clear: true
  world_nether:
    enable-auto-clear: true
  world_the_end:
    enable-auto-clear: true

# Player notifications
notify-players:
  enable: true
  message: "All dropped items will be cleared in 299 seconds!"
  countdown: 299

# Messages
clear-message: "§aGarbage collected correctly."
warning-message: "§cPicking up trash in{time}..."
broadcast-message: "§bThe items will be deleted in{time} seconds."
```

## Commands

- `/clearlagg` - Clears all dropped items in the configured worlds.
- `/clearlagg stats` - Displays statistics about the cleared items.

## Permissions

- `clearlagg.use` - Allows the player to use the `/clearlagg` command.
- `clearlagg.stats` - Allows the player to view clearlagg statistics.

## Usage

### Manually Clear Items

Use the `/clearlagg` command to manually clear all dropped items in the configured worlds. 

```plaintext
/clearlagg
```

### View Statistics

Use the `/clearlagg stats` command to view the statistics of cleared items.

```plaintext
/clearlagg stats
```

## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE](LICENSE) file for details.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request on [GitHub](https://github.com/XPocketMC/clearlagg) if you have any improvements or bug fixes.

## Acknowledgements

- PocketMine-MP for providing the API and platform to develop this plugin.
- All contributors and users for their support and feedback.
---
Created by *XPocketMC*