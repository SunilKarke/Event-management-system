-- First add role column to users table if it doesn't exist
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `role` VARCHAR(20) NOT NULL DEFAULT 'user' AFTER `password`;

-- If using older MySQL that doesn't support IF NOT EXISTS for ADD COLUMN:
-- Run this instead (will error if column exists, that's ok):
-- ALTER TABLE `users` ADD `role` VARCHAR(20) NOT NULL DEFAULT 'user' AFTER `password`;

-- Create applications table if not exists
CREATE TABLE IF NOT EXISTS `applications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  `applied_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (`event_id`) REFERENCES events(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;