module.exports = {
  prefix: 'tw-',
  theme: {
    inset: {
      '0': 0,
      auto: 'auto',
      2: '2rem'
    },
    extend: {
      boxShadow: {
        sm: '0 2px 3px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06)',
      },
      borderWidth: {
        '1': '1px',
      },
      padding: {
        '18': '4.5rem'
      },
      fontSize: {
        '7xl': '5rem'
      },
    },

    zIndex: {
      auto: 'auto',
      '0': '0',
      '10': '10',
      '20': '20',
      '30': '30',
      '40': '40',
      '50': '50',
      '1040': 1040,
      '1050': 1050,
    },

    /**
     * Bellow config related to the third party TailwindCss packages
     */
    pagination: theme => ({
      color: theme('colors.indigo.600'),
      link: 'px-3 py-2 bg-white block border',
      wrapper: 'flex justify-center my-4',
      item: 'block',
      linkFirst: 'border-l border-r bg-gray-200 rounded-l-sm',
      linkLast: 'border-r border-l bg-gray-200 rounded-r-sm',
    }),

    transitionProperty: {
        'none': 'none',
        'all': 'all',
        'color': 'color',
        'bg': 'background-color',
        'border': 'border-color',
        'colors': ['color', 'background-color', 'border-color'],
        'opacity': 'opacity',
        'transform': 'transform',
        'shadow': 'box-shadow',
    },
    transitionDuration: {
        'default': '250ms',
        '0': '0ms',
        '100': '100ms',
        '150': '150ms',
        '250': '250ms',
        '500': '500ms',
        '750': '750ms',
        '1000': '1000ms',
    },
    transitionTimingFunction: {
        'default': 'ease',
        'linear': 'linear',
        'ease': 'ease',
        'ease-in': 'ease-in',
        'ease-out': 'ease-out',
        'ease-in-out': 'ease-in-out',
    },
    transitionDelay: {
        'default': '0ms',
        '0': '0ms',
        '100': '100ms',
        '250': '250ms',
        '500': '500ms',
        '750': '750ms',
        '1000': '1000ms',
    },
    willChange: {
        'auto': 'auto',
        'scroll': 'scroll-position',
        'contents': 'contents',
        'opacity': 'opacity',
        'transform': 'transform',
    }
  },
  variants: {
      transitionProperty: ['responsive'],
      transitionDuration: ['responsive'],
      transitionTimingFunction: ['responsive'],
      transitionDelay: ['responsive'],
      willChange: ['responsive']
  },
  plugins: [
      require('@tailwindcss/custom-forms'),
      require('tailwindcss-plugins/pagination'),
      require('tailwindcss-transitions')()
  ]
}
