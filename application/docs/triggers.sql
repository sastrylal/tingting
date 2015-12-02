CREATE TRIGGER `after_member_insert` AFTER INSERT ON `tbl_members`
 FOR EACH ROW INSERT INTO tbl_member_geo( member_id, is_online ) VALUES (NEW.member_id, '1')
