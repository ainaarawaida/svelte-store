import { defineConfig,loadEnv  } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'
import { chunkSplitPlugin } from 'vite-plugin-chunk-split';


export default ({ mode }) => {
  process.env = {...process.env, ...loadEnv(mode, process.cwd())};

  let myrealbase = process.env.VITE_MYBASE ; 
  
  if(mode !== "development"){ //prod
      
      process.env.VITE_MYPLUGINURL = myrealbase ; 
      process.env.VITE_MYLINKURL = `` ; 
      process.env.VITE_MYBASEURL = myrealbase ; 
      process.env.VITE_MYBASE = `` ; 
  }else{ //dev
      
      process.env.VITE_MYPLUGINURL = `` ; 
      process.env.VITE_MYLINKURL = myrealbase ; 
      process.env.VITE_MYBASEURL = `` ; 
      process.env.VITE_MYBASE = myrealbase ; 
  }
    

    // import.meta.env.VITE_NAME available here with: process.env.VITE_NAME
    // import.meta.env.VITE_PORT available here with: process.env.VITE_PORT

    return defineConfig({
      base: myrealbase,
      plugins: [
      svelte(),
      chunkSplitPlugin({
        strategy: 'unbundle'
      })],
      optimizeDeps: { exclude: ["svelte-navigator"] },
    });

}

