import countries from "./countries.json";

export default {
  data() {
    return {
      currencies: "",
    };
  },

  methods: {
    allSymbols() {
      let currencies = [];
      countries.map((country) => {
        currencies.push(country.symbol);
      });
      return (this.currencies = currencies);
    },

    currencySymbol(name) {
      name = name.toLowerCase().trim();

      let currencySymbol;

      countries.map((country) => {
        let countryArray = country.currency.split(" ");
        let currencyName = countryArray.pop().toLowerCase().trim();
        let currencyAbbr = country.abbreviation.toLowerCase();
        let countryName = countryArray.join(" ").toLowerCase().trim();

        if (
          name === currencyName ||
          name === countryName ||
          name === currencyAbbr
        ) {
          currencySymbol = country.symbol;
        }
      });
      return currencySymbol;
    },
  },
};
