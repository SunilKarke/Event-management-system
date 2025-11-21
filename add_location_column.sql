USE event_m;

-- Add location column if it doesn't exist
SET @exist := (
    SELECT COUNT(*)
    FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = 'event_m'
    AND TABLE_NAME = 'events'
    AND COLUMN_NAME = 'location'
);

SET @sql := IF(
    @exist = 0,
    'ALTER TABLE events ADD COLUMN location VARCHAR(255) NOT NULL DEFAULT "" AFTER event_datetime',
    'SELECT "Location column already exists."'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;