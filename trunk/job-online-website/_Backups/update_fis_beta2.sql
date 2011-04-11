ALTER TABLE `fields`  ADD COLUMN `DependentFields` TEXT NULL AFTER `ValidationRules`;
ALTER TABLE `fieldoptions`  ADD COLUMN `DependentOptions` TEXT NULL AFTER `OptionName`;