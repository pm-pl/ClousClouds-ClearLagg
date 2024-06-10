# ClearLagg

ClearLagg is a PocketMine-MP plugin designed to reduce lag by periodically cleaning up dropped items in the Minecraft world. This plugin includes advanced features and customization options to better manage server performance and player experience.

## Features

- **Periodic Cleanup:** Cleans up dropped items at configurable time intervals.
- **Manual Cleanup Command:** Provides a command to manually trigger item cleanup.
- **Player Notifications:** Configurable messages to notify players of cleanup events.
- **Selective Cleanup:** Options to exclude specific types of entities from being cleaned up.
- **Detailed Statistics:** Tracks and displays statistics about items cleaned up.
- **Configurable Per World:** Set different cleanup intervals and settings for each world.

## Installation

1. Download the ClearLagg plugin.
2. Extract the contents of the ZIP file into the `plugins` folder on your PocketMine-MP server.
3. Restart your server.

## Configuration

After installing the plugin, configure it via the `config.yml` file located in the `plugin_data/ClearLagg` folder.

### Example `config.yml`

```yaml
interval: 300
broadcast: true
message: "Cleared {count} items!"
exclude_named: true
worlds:
  world_nether:
    interval: 600
    broadcast: false
  world_end:
    interval: 1200
    broadcast: true
    message: "End items cleared!"
```

- `interval`: The default time interval in seconds for automatic item cleanup.
- `broadcast`: If set to `true`, cleanup messages will be sent to all players.
- `message`: The message sent after cleanup. `{count}` will be replaced with the number of items cleaned up.
- `exclude_named`: Excludes named items from being cleaned up.
- `worlds`: Specific settings for different worlds.

## Usage

### Commands

- `/clearlagg` - Cleans up all dropped items. Requires the `clearlagg.use` permission.
- `/clearlagg stats` - Displays cleanup statistics. Requires the `clearlagg.stats` permission.

### Permissions

- `clearlagg.use` - Permission to use the `/clearlagg` command.
- `clearlagg.stats` - Permission to view cleanup statistics.

## License

This plugin is licensed under the GNU General Public License v3.0 (GPL-3.0). See the `LICENSE` file for more information.

---

Created by XPocketMC 
