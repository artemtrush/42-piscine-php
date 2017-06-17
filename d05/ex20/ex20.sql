SELECT A.`id_genre`, B.`name` AS `name_genre`, C.`id_distrib`,
C.`name` AS `name_distrib`, A.`title` AS `title_film`
FROM `film` A LEFT JOIN `genre` B ON A.`id_genre` = B.`id_genre`
LEFT JOIN `distrib` C ON A.`id_distrib` = C.`id_distrib`
WHERE A.`id_genre` BETWEEN 4 AND 8;