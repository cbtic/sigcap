CREATE OR REPLACE FUNCTION last_day_month(tyear INTEGER, tmonth INTEGER)
RETURNS VARCHAR AS
$$ BEGIN
    RETURN TO_CHAR(TO_TIMESTAMP(tyear || '-' || TO_CHAR(tmonth,'FM00') || '-01', 'YYYY-MM-DD') + INTERVAL '1 month' - INTERVAL '1 days', 'YYYY-MM-DD');
END; $$
LANGUAGE plpgsql;
