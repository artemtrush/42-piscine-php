SELECT A.`title` AS `Title`, A.`summary` AS `Summary`, A.`prod_year`
FROM `film` A INNER JOIN `genre` B ON A.`id_genre` = B.`id_genre`
WHERE B.`name` = 'erotic'
ORDER BY `prod_year` DESC;