<style>

  @media only screen and (min-width: 992px) {
    .layout_games-main {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      grid-auto-rows: 16.5rem;
      grid-gap: 1.25em;
    }

    .item_games-main:nth-child(6n+1) {
      grid-column: 1 / 3;
    }

    .item_games-main:nth-child(6n+2) {
      grid-column: 3 / 6;
      grid-row: auto;
    }

    .item_games-main:nth-child(6n+3) {
      grid-column: 3 / 6;
      grid-row: auto;
    }

    .item_games-main:nth-child(6n+4) {
      grid-column: 1 / 4;
      grid-row: auto;
    }

    .item_games-main:nth-child(6n+5) {
      grid-column: 1 / 4;
      grid-row: auto;
    }

    .item_games-main:nth-child(6n+6) {
      grid-column: 4 / 6;
    }


    /* Row position 10n+1  */
    .item_games-main:nth-child(1) {
      grid-row: 1 / 3;
    }

    .item_games-main:nth-child(7) {
      grid-row: 5 / 7;
    }

    .item_games-main:nth-child(13) {
      grid-row: 9 / 11;
    }

    .item_games-main:nth-child(19) {
      grid-row: 13 / 15;
    }

    .item_games-main:nth-child(25) {
      grid-row: 17 / 19;
    }

    .item_games-main:nth-child(31) {
      grid-row: 21 / 23;
    }

    .item_games-main:nth-child(37) {
      grid-row: 25 / 27;
    }

    .item_games-main:nth-child(43) {
      grid-row: 29 / 31;
    }

    .item_games-main:nth-child(49) {
      grid-row: 33 / 35;
    }

    .item_games-main:nth-child(55) {
      grid-row: 37 / 39;
    }

    .item_games-main:nth-child(61) {
      grid-row: 41 / 43;
    }

    .item_games-main:nth-child(67) {
      grid-row: 45 / 47;
    }

    .item_games-main:nth-child(73) {
      grid-row: 49 / 51;
    }

    .item_games-main:nth-child(79) {
      grid-row: 53 / 55;
    }

    .item_games-main:nth-child(85) {
      grid-row: 57 / 59;
    }

    .item_games-main:nth-child(91) {
      grid-row: 61 / 63;
    }

    .item_games-main:nth-child(97) {
      grid-row: 65 / 67;
    }

    /* Row position 10n+10  */
    .item_games-main:nth-child(6) {
      grid-row: 3 / 5;
    }

    .item_games-main:nth-child(12) {
      grid-row: 7 / 9;
    }

    .item_games-main:nth-child(18) {
      grid-row: 11 / 13;
    }

    .item_games-main:nth-child(24) {
      grid-row: 15 / 17;
    }

    .item_games-main:nth-child(30) {
      grid-row: 19 / 21;
    }

    .item_games-main:nth-child(36) {
      grid-row: 23 / 25;
    }

    .item_games-main:nth-child(42) {
      grid-row: 27 / 29;
    }

    .item_games-main:nth-child(48) {
      grid-row: 31 / 33;
    }

    .item_games-main:nth-child(54) {
      grid-row: 35 / 37;
    }

    .item_games-main:nth-child(60) {
      grid-row: 39 / 41;
    }

    .item_games-main:nth-child(66) {
      grid-row: 43 / 45;
    }

    .item_games-main:nth-child(72) {
      grid-row: 47 / 49;
    }

    .item_games-main:nth-child(78) {
      grid-row: 51 / 53;
    }

    .item_games-main:nth-child(84) {
      grid-row: 55 / 57;
    }

    .item_games-main:nth-child(90) {
      grid-row: 59 / 61;
    }

    .item_games-main:nth-child(96) {
      grid-row: 63 / 65;
    }

    .item_games-main:nth-child(102) {
      grid-row: 67 / 69;
    }


    /* Large card is visible */
    .item_games-main:nth-child(6n+1) .card_news.is-large {
      display: flex;
    }

    .item_games-main:nth-child(6n+6) .card_news.is-large {
      display: flex;
    }

    /* Small card is hide */
    .item_games-main:nth-child(6n+1) .card_news.is-small {
      display: none;
    }

    .item_games-main:nth-child(6n+6) .card_news.is-small {
      display: none;
    }

    /* First element */
    .item_games-main:nth-child(1) .card_news {
      background-color: #7A1DFF;
      color: #fff;
    }

    .item_games-main:nth-child(1) .card_first {
      display: flex;
    }

    .item_games-main:nth-child(1) .card_dark {
      display: none;
    }
  }

</style>
