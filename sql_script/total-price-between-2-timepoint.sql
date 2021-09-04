SELECT SUM(bid_price) FROM transaction_history
WHERE recorded_at > STR_TO_DATE('2022-01-01 00:00:00', '%Y-%m-%d %H:%i:%s')
AND recorded_at < STR_TO_DATE('2022-06-30 00:00:00', '%Y-%m-%d %H:%i:%s')