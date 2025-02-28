<?php

namespace ccxt\pro;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

use Exception; // a common import
use React\Async;

class hitbtc extends \ccxt\async\hitbtc {

    public function describe() {
        return $this->deep_extend(parent::describe(), array(
            'has' => array(
                'ws' => true,
                'watchTicker' => true,
                'watchTickers' => false, // not available on exchange side
                'watchTrades' => true,
                'watchOrderBook' => true,
                'watchBalance' => false, // not implemented yet
                'watchOHLCV' => true,
            ),
            'urls' => array(
                'api' => array(
                    'ws' => 'wss://api.hitbtc.com/api/2/ws',
                ),
            ),
            'options' => array(
                'tradesLimit' => 1000,
                'methods' => array(
                    'orderbook' => 'subscribeOrderbook',
                    'ticker' => 'subscribeTicker',
                    'trades' => 'subscribeTrades',
                    'ohlcv' => 'subscribeCandles',
                ),
            ),
        ));
    }

    public function watch_public(string $symbol, $channel, $timeframe = null, $params = array ()) {
        return Async\async(function () use ($symbol, $channel, $timeframe, $params) {
            Async\await($this->load_markets());
            $marketId = $this->market_id($symbol);
            $url = $this->urls['api']['ws'];
            $messageHash = $channel . ':' . $marketId;
            if ($timeframe !== null) {
                $messageHash .= ':' . $timeframe;
            }
            $methods = $this->safe_value($this->options, 'methods', array());
            $method = $this->safe_string($methods, $channel, $channel);
            $requestId = $this->nonce();
            $subscribe = array(
                'method' => $method,
                'params' => array(
                    'symbol' => $marketId,
                ),
                'id' => $requestId,
            );
            $request = $this->deep_extend($subscribe, $params);
            return Async\await($this->watch($url, $messageHash, $request, $messageHash));
        }) ();
    }

    public function watch_order_book(string $symbol, ?int $limit = null, $params = array ()) {
        return Async\async(function () use ($symbol, $limit, $params) {
            /**
             * watches information on open orders with bid (buy) and ask (sell) prices, volumes and other data
             * @param {string} $symbol unified $symbol of the market to fetch the order book for
             * @param {int} [$limit] the maximum amount of order book entries to return
             * @param {array} [$params] extra parameters specific to the hitbtc api endpoint
             * @return {array} A dictionary of ~@link https://docs.ccxt.com/#/?id=order-book-structure order book structures~ indexed by market symbols
             */
            $orderbook = Async\await($this->watch_public($symbol, 'orderbook', null, $params));
            return $orderbook->limit ();
        }) ();
    }

    public function handle_order_book_snapshot(Client $client, $message) {
        //
        //     {
        //         jsonrpc => "2.0",
        //         method => "snapshotOrderbook",
        //         $params => {
        //             ask => array(
        //                 array( price => "6927.75", size => "0.11991" ),
        //                 array( price => "6927.76", size => "0.06200" ),
        //                 array( price => "6927.85", size => "0.01000" ),
        //             ),
        //             bid => array(
        //                 array( price => "6926.18", size => "0.16898" ),
        //                 array( price => "6926.17", size => "0.06200" ),
        //                 array( price => "6925.97", size => "0.00125" ),
        //             ),
        //             $symbol => "BTCUSD",
        //             sequence => 494854,
        //             $timestamp => "2020-04-03T08:58:53.460Z"
        //         }
        //     }
        //
        $params = $this->safe_value($message, 'params', array());
        $marketId = $this->safe_string($params, 'symbol');
        $market = $this->safe_market($marketId);
        $symbol = $market['symbol'];
        $timestamp = $this->parse8601($this->safe_string($params, 'timestamp'));
        $nonce = $this->safe_integer($params, 'sequence');
        if (is_array($this->orderbooks) && array_key_exists($symbol, $this->orderbooks)) {
            unset($this->orderbooks[$symbol]);
        }
        $snapshot = $this->parse_order_book($params, $symbol, $timestamp, 'bid', 'ask', 'price', 'size');
        $orderbook = $this->order_book($snapshot);
        $orderbook['nonce'] = $nonce;
        $this->orderbooks[$symbol] = $orderbook;
        $messageHash = 'orderbook:' . $marketId;
        $client->resolve ($orderbook, $messageHash);
    }

    public function handle_order_book_update(Client $client, $message) {
        //
        //     {
        //         jsonrpc => "2.0",
        //         method => "updateOrderbook",
        //         $params => {
        //             ask => array(
        //                 array( price => "6940.65", size => "0.00000" ),
        //                 array( price => "6940.66", size => "6.00000" ),
        //                 array( price => "6943.52", size => "0.04707" ),
        //             ),
        //             bid => array(
        //                 array( price => "6938.40", size => "0.11991" ),
        //                 array( price => "6938.39", size => "0.00073" ),
        //                 array( price => "6936.65", size => "0.00000" ),
        //             ),
        //             $symbol => "BTCUSD",
        //             sequence => 497872,
        //             $timestamp => "2020-04-03T09:03:56.685Z"
        //         }
        //     }
        //
        $params = $this->safe_value($message, 'params', array());
        $marketId = $this->safe_string($params, 'symbol');
        $market = $this->safe_market($marketId);
        $symbol = $market['symbol'];
        if (is_array($this->orderbooks) && array_key_exists($symbol, $this->orderbooks)) {
            $timestamp = $this->parse8601($this->safe_string($params, 'timestamp'));
            $nonce = $this->safe_integer($params, 'sequence');
            $orderbook = $this->orderbooks[$symbol];
            $asks = $this->safe_value($params, 'ask', array());
            $bids = $this->safe_value($params, 'bid', array());
            $this->handle_deltas($orderbook['asks'], $asks);
            $this->handle_deltas($orderbook['bids'], $bids);
            $orderbook['timestamp'] = $timestamp;
            $orderbook['datetime'] = $this->iso8601($timestamp);
            $orderbook['nonce'] = $nonce;
            $this->orderbooks[$symbol] = $orderbook;
            $messageHash = 'orderbook:' . $marketId;
            $client->resolve ($orderbook, $messageHash);
        }
    }

    public function handle_delta($bookside, $delta) {
        $price = $this->safe_float($delta, 'price');
        $amount = $this->safe_float($delta, 'size');
        $bookside->store ($price, $amount);
    }

    public function handle_deltas($bookside, $deltas) {
        for ($i = 0; $i < count($deltas); $i++) {
            $this->handle_delta($bookside, $deltas[$i]);
        }
    }

    public function watch_ticker(string $symbol, $params = array ()) {
        return Async\async(function () use ($symbol, $params) {
            /**
             * watches a price ticker, a statistical calculation with the information calculated over the past 24 hours for a specific market
             * @param {string} $symbol unified $symbol of the market to fetch the ticker for
             * @param {array} [$params] extra parameters specific to the hitbtc api endpoint
             * @return {array} a ~@link https://docs.ccxt.com/#/?id=ticker-structure ticker structure~
             */
            return Async\await($this->watch_public($symbol, 'ticker', null, $params));
        }) ();
    }

    public function handle_ticker(Client $client, $message) {
        //
        //     {
        //         jsonrpc => '2.0',
        //         $method => 'ticker',
        //         $params => {
        //             ask => '6983.22',
        //             bid => '6980.77',
        //             last => '6980.77',
        //             open => '6650.05',
        //             low => '6606.45',
        //             high => '7223.11',
        //             volume => '79264.33941',
        //             volumeQuote => '540183372.5134832',
        //             timestamp => '2020-04-03T10:02:18.943Z',
        //             $symbol => 'BTCUSD'
        //         }
        //     }
        //
        $params = $this->safe_value($message, 'params');
        $marketId = $this->safe_value($params, 'symbol');
        $market = $this->safe_market($marketId);
        $symbol = $market['symbol'];
        $result = $this->parse_ticker($params, $market);
        $this->tickers[$symbol] = $result;
        $method = $this->safe_value($message, 'method');
        $messageHash = $method . ':' . $marketId;
        $client->resolve ($result, $messageHash);
    }

    public function watch_trades(string $symbol, ?int $since = null, ?int $limit = null, $params = array ()) {
        return Async\async(function () use ($symbol, $since, $limit, $params) {
            /**
             * get the list of most recent $trades for a particular $symbol
             * @param {string} $symbol unified $symbol of the market to fetch $trades for
             * @param {int} [$since] timestamp in ms of the earliest trade to fetch
             * @param {int} [$limit] the maximum amount of $trades to fetch
             * @param {array} [$params] extra parameters specific to the hitbtc api endpoint
             * @return {array[]} a list of ~@link https://docs.ccxt.com/en/latest/manual.html?#public-$trades trade structures~
             */
            $trades = Async\await($this->watch_public($symbol, 'trades', null, $params));
            if ($this->newUpdates) {
                $limit = $trades->getLimit ($symbol, $limit);
            }
            return $this->filter_by_since_limit($trades, $since, $limit, 'timestamp', true);
        }) ();
    }

    public function handle_trades(Client $client, $message) {
        //
        //     {
        //         jsonrpc => '2.0',
        //         method => 'snapshotTrades', // updateTrades
        //         $params => {
        //             $data => array(
        //                 array(
        //                     id => 814145791,
        //                     price => '6957.20',
        //                     quantity => '0.02779',
        //                     side => 'buy',
        //                     timestamp => '2020-04-03T10:28:20.032Z'
        //                 ),
        //                 array(
        //                     id => 814145792,
        //                     price => '6957.20',
        //                     quantity => '0.12918',
        //                     side => 'buy',
        //                     timestamp => '2020-04-03T10:28:20.039Z'
        //                 ),
        //             ),
        //             $symbol => 'BTCUSD'
        //         }
        //     }
        //
        $params = $this->safe_value($message, 'params', array());
        $data = $this->safe_value($params, 'data', array());
        $marketId = $this->safe_string($params, 'symbol');
        $market = $this->safe_market($marketId);
        $symbol = $market['symbol'];
        $messageHash = 'trades:' . $marketId;
        $tradesLimit = $this->safe_integer($this->options, 'tradesLimit', 1000);
        $stored = $this->safe_value($this->trades, $symbol);
        if ($stored === null) {
            $stored = new ArrayCache ($tradesLimit);
            $this->trades[$symbol] = $stored;
        }
        if (gettype($data) === 'array' && array_keys($data) === array_keys(array_keys($data))) {
            $trades = $this->parse_trades($data, $market);
            for ($i = 0; $i < count($trades); $i++) {
                $stored->append ($trades[$i]);
            }
        } else {
            $trade = $this->parse_trade($message, $market);
            $stored->append ($trade);
        }
        $client->resolve ($stored, $messageHash);
        return $message;
    }

    public function watch_ohlcv(string $symbol, $timeframe = '1m', ?int $since = null, ?int $limit = null, $params = array ()) {
        return Async\async(function () use ($symbol, $timeframe, $since, $limit, $params) {
            /**
             * watches historical candlestick data containing the open, high, low, and close price, and the volume of a market
             * @param {string} $symbol unified $symbol of the market to fetch OHLCV data for
             * @param {string} $timeframe the length of time each candle represents
             * @param {int} [$since] timestamp in ms of the earliest candle to fetch
             * @param {int} [$limit] the maximum amount of candles to fetch
             * @param {array} [$params] extra parameters specific to the hitbtc api endpoint
             * @return {int[][]} A list of candles ordered, open, high, low, close, volume
             */
            // if ($limit === null) {
            //     $limit = 100;
            // }
            $period = $this->safe_string($this->timeframes, $timeframe, $timeframe);
            $request = array(
                'params' => array(
                    'period' => $period,
                    // 'limit' => $limit,
                ),
            );
            $requestParams = $this->deep_extend($request, $params);
            $ohlcv = Async\await($this->watch_public($symbol, 'ohlcv', $period, $requestParams));
            if ($this->newUpdates) {
                $limit = $ohlcv->getLimit ($symbol, $limit);
            }
            return $this->filter_by_since_limit($ohlcv, $since, $limit, 0, true);
        }) ();
    }

    public function handle_ohlcv(Client $client, $message) {
        //
        //     {
        //         jsonrpc => '2.0',
        //         method => 'snapshotCandles', // updateCandles
        //         $params => {
        //             $data => array(
        //                 array(
        //                     timestamp => '2020-04-05T00:06:00.000Z',
        //                     open => '6869.40',
        //                     close => '6867.16',
        //                     min => '6863.17',
        //                     max => '6869.4',
        //                     volume => '0.08947',
        //                     volumeQuote => '614.4195442'
        //                 ),
        //                 array(
        //                     timestamp => '2020-04-05T00:07:00.000Z',
        //                     open => '6867.54',
        //                     close => '6859.26',
        //                     min => '6858.85',
        //                     max => '6867.54',
        //                     volume => '1.7766',
        //                     volumeQuote => '12191.5880395'
        //                 ),
        //             ),
        //             $symbol => 'BTCUSD',
        //             $period => 'M1'
        //         }
        //     }
        //
        $params = $this->safe_value($message, 'params', array());
        $data = $this->safe_value($params, 'data', array());
        $marketId = $this->safe_string($params, 'symbol');
        $market = $this->safe_market($marketId);
        $symbol = $market['symbol'];
        $period = $this->safe_string($params, 'period');
        $timeframe = $this->find_timeframe($period);
        $messageHash = 'ohlcv:' . $marketId . ':' . $period;
        for ($i = 0; $i < count($data); $i++) {
            $candle = $data[$i];
            $parsed = $this->parse_ohlcv($candle, $market);
            $this->ohlcvs[$symbol] = $this->safe_value($this->ohlcvs, $symbol, array());
            $stored = $this->safe_value($this->ohlcvs[$symbol], $timeframe);
            if ($stored === null) {
                $limit = $this->safe_integer($this->options, 'OHLCVLimit', 1000);
                $stored = new ArrayCacheByTimestamp ($limit);
                $this->ohlcvs[$symbol][$timeframe] = $stored;
            }
            $stored->append ($parsed);
            $client->resolve ($stored, $messageHash);
        }
        return $message;
    }

    public function handle_notification(Client $client, $message) {
        //
        //     array( jsonrpc => '2.0', result => true, id => null )
        //
        return $message;
    }

    public function handle_message(Client $client, $message) {
        $methods = array(
            'snapshotOrderbook' => array($this, 'handle_order_book_snapshot'),
            'updateOrderbook' => array($this, 'handle_order_book_update'),
            'ticker' => array($this, 'handle_ticker'),
            'snapshotTrades' => array($this, 'handle_trades'),
            'updateTrades' => array($this, 'handle_trades'),
            'snapshotCandles' => array($this, 'handle_ohlcv'),
            'updateCandles' => array($this, 'handle_ohlcv'),
        );
        $event = $this->safe_string($message, 'method');
        $method = $this->safe_value($methods, $event);
        if ($method === null) {
            $this->handle_notification($client, $message);
        } else {
            $method($client, $message);
        }
    }
}
