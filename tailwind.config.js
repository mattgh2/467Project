module.exports = {
  theme: {
    extend: {
      keyframes: {
        'bounce-once': {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-25%)' },
        },
      },
      animation: {
        'bounce-once': 'bounce-once 0.6s ease',
      },
    },
  },
};
