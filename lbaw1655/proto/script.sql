UPDATE "Auction" SET state = 'Opened'::auctionstate WHERE state = 'Scheduled'::auctionstate AND startingdate < current_timestamp;
UPDATE "Auction" SET state = 'Awaiting_payment'::auctionstate WHERE state = 'Opened'::auctionstate AND (startingdate + (durationhours || 'hours')::interval) < current_timestamp;