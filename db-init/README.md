# Database initialization

MySQL automatically runs every `*.sql`, `*.sql.gz`, and `*.sh` file in this folder
when the database starts for the **first time** (when the volume `db_data` is empty).

After the first boot, subsequent restarts ignore this folder — re-importing requires
deleting the volume.

## Exporting your local database

From your **local** WordPress install (Local by Flywheel, MAMP, etc.), generate a SQL dump:

### Option A — Local by Flywheel (easiest)

1. Right-click your site in Local → **Open site shell**
2. Run:
   ```
   wp db export /tmp/init.sql --add-drop-table --default-character-set=utf8mb4
   ```
3. Copy `/tmp/init.sql` into this `db-init/` folder.

### Option B — mysqldump directly

```bash
mysqldump -h 127.0.0.1 -P 10001 -u root -proot \
    --default-character-set=utf8mb4 --add-drop-table local \
    > db-init/init.sql
```

(Adjust port — Local by Flywheel typically uses a custom port shown in **Database** tab.)

### Option C — wp-cli on your local site

```bash
wp db export db-init/init.sql --add-drop-table
```

## Important: replace local URLs with production

Your dump contains `http://elena.local` everywhere. Production needs the real domain.

After deploying, run inside the WordPress container (Coolify → Terminal):

```bash
wp search-replace "http://elena.local" "https://yourdomain.com" --all-tables --skip-columns=guid
wp search-replace "elena.local"        "yourdomain.com"         --all-tables --skip-columns=guid
wp cache flush
```

## Force re-import on next deploy

If you push a new SQL dump and want it re-imported:

1. In Coolify → service → **Storage** tab → delete the `db_data` volume
2. Redeploy

⚠️ Deleting `db_data` wipes all production data created since the last import.
