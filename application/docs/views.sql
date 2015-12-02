CREATE OR REPLACE VIEW view_member_posts AS
SELECT m.member_id, p.post_id, p.content, p.latitude, p.longitude, p.expiry_date, p.member_id AS posted_by, 
    ROUND(acos(sin(radians(p.latitude))*sin(radians(m.latitude)) + cos(radians(p.latitude))*cos(radians(m.latitude))*cos(radians(m.longitude)-radians(p.longitude))) * 6371, 2) AS dist 
FROM tbl_member_geo m, tbl_posts p 
WHERE (m.latitude Between p.minlat AND p.maxlat) AND (m.longitude Between p.minlon AND p.maxlon)
ORDER BY dist ASC

CREATE OR REPLACE VIEW view_posts_min_max AS
SELECT p.post_id, p.content, 
ROUND(acos(sin(radians(p.latitude))*sin(radians(p.minlat)) + cos(radians(p.latitude))*cos(radians(p.minlat))*cos(radians(p.minlon)-radians(p.longitude))) * 6371, 2) AS min_dist,
ROUND(acos(sin(radians(p.latitude))*sin(radians(p.maxlat)) + cos(radians(p.latitude))*cos(radians(p.maxlat))*cos(radians(p.maxlon)-radians(p.longitude))) * 6371, 2) AS min_dist,
FROM tbl_posts p 