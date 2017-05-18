<!-- 2 : auctions -->
<div class="row">
    <div class="auctions-content hidden">
        <div class="col-sm-2 sidebar">
            <ul id="myAuctions-navigation" class="nav nav-sidebar">
                <li class="active followedAuctions"><a>Followed <span id="followedAuctionsBadge" class="badge"></span></a></li>
                <li class="inConclusionAuctions"><a>In Conclusion <span id="inConclusionAuctionsBadge" class="badge"></span></a></li>
                <li class="historyAuctions"><a>History <span id="historyAuctionsBadge" class="badge"></span></a></li>
            </ul>
        </div>
        <!-- FOLLOWED -->
        <div class="auctions-content followedAuctions">
            <div class="col-sm-10">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Auction</th>
                            <th>Timeleft</th>
                        </tr>
                        </thead>
                        <tbody id="followedAuctionsTable">
                        <!-- Followed Auctions Table body-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
         <!-- IN CONCLUSION -->
        <div class="auctions-content inConclusionAuctions hidden">
            <div class="col-sm-10">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th colspan="1">Auction</th>
                            <th colspan="1">Type</th>
                            <th colspan="2" class="text-center">State</th>
                        </tr>
                        </thead>
                        <tbody id="inConclusionAuctionsTable">
                        <!-- In Conclusion Auctions Table Body-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- HISTORY -->
        <div class="auctions-content historyAuctions hidden">
            <div class="col-sm-10">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Auction</th>
                            <th>Date</th>
                            <th>Price</th>
                            <th>Rating</th>
                        </tr>
                        </thead>
                        <tbody id="historyAuctionsTable">
                        <!--History Auctions Table Body -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> <!-- termina a row 2 -->