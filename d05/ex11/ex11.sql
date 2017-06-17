SELECT UPPER(A.`last_name`) AS `NAME` , A.`first_name`, C.`price`
FROM `user_card` A INNER JOIN `member` B ON A.`id_user` = B.`id_user_card`
INNER JOIN `subscription` C ON B.`id_sub` = C.`id_sub`
WHERE C.`price` > 42
ORDER BY A.`last_name` ASC, A.`first_name` ASC;