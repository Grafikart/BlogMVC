<?php

class BlogCache {

    public function destroy() {
        if ( Cache::has('sidebar_categories') ) {
            Cache::forget('sidebar_categories');
        }
        if ( Cache::has('sidebar_posts') ) {
            Cache::forget('sidebar_posts');
        }
    }
}
