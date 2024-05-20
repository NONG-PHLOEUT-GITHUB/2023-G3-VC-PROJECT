# frontend

## Project setup
```
npm install
```

### Step 2: Update Environment Variables
- [x] Update <code>env.production</code> and <code>env.development</code> with IP Address of your Backend server

Copy .env.example rename .env.local or .env.development

#### Example for <code>developement</code> [It work for local] file:

VUE_APP_MODE=Development
VUE_APP_API_URL=http://localhost:8000/api


#### Example for <code>production </code> [It work when deploy] file:

VUE_APP_MODE=production
VUE_APP_API_URL=http://localhost:8000/api


### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```


### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).
