# Gunakan image PocketMine-MP yang sudah ada
FROM pmmp/pocketmine-mp:latest

# Salin source code dan plugin.yml ke dalam container
COPY src /home/pocketmine/plugins/ClearLagg/src
COPY plugin.yml /home/pocketmine/plugins/ClearLagg/

# Set workdir ke direktori PocketMine
WORKDIR /home/pocketmine

# Build plugin menjadi .phar
RUN ./bin/php7/bin/php PocketMine-MP.phar --makeplugin ClearLagg \
    && mv ClearLagg.phar /home/pocketmine/ClearLagg.phar

CMD ["./bin/php7/bin/php", "-v"]
