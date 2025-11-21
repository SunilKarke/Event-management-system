USE event_m;

-- Add max_participants column if it doesn't exist
ALTER TABLE events 
ADD COLUMN max_participants INT NOT NULL DEFAULT 100 AFTER location;