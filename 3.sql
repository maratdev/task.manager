<?php

SELECT * FROM CAR WHERE kilometrage < 50000 AND year_of_make < 2017;

SELECT AVG(power) as power_AUDI FROM CAR WHERE marque = 'AUDI' AND engine= 'diesel';

SELECT car_id as count_car, deal_date, name, marque
FROM DEAL
INNER JOIN CLIENT ON DEAL.client_id=CLIENT.id
INNER JOIN CAR ON DEAL.car_id=CAR.id
WHERE client_id = 1 AND YEAR(deal_date) >= '2010' AND YEAR(deal_date) <= '2020'


SELECT
'diesel' as engine, (SELECT AVG(price) FROM CAR WHERE engine IN ('diesel') AND power > 150) as price_engine,
'petrol' as engines, (SELECT AVG(price) FROM CAR WHERE engine IN ('petrol') AND power > 150) as price_engines


SELECT marque, COUNT(*) AS count_car
  FROM CAR
    INNER JOIN DEAL ON car_id = CAR.id
  WHERE (YEAR(deal_date) >= '2018' AND YEAR(deal_date) <= '2020')
  GROUP BY marque ORDER BY marque