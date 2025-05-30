AppSumo WordPress SDK
======================

AppSumo SDK enables AppSumo Activation System through Microservice. Shows (redirects to) Activation Form and automatically checks License Token every week.  

## Initialization

For **DEVELOPMENT** case, you can just clone the AppSumo repository to root directory of your project - https://bitbucket.org/stylemixthemes/appsumo/.

Then you need to initialize the SDK at the begining of your Plugin/Theme main PHP file:

```php
if ( ! function_exists( 'your_prefix_appsumo' ) && file_exists( dirname( __FILE__ ) . '/appsumo/main.php' ) ) {
    function your_prefix_appsumo() {
        require_once dirname( __FILE__ ) . '/appsumo/main.php';

        return appsumo_init(
            array(
                'item'      => 'myproplugin', // Sample: masterstudy
                'name'      => 'My PRO Plugin', // Sample: MasterStudy LMS PRO
                'main_file' => __FILE__,
            )
        );
    }
}
```

## Usage

After initialization, you can scope your Plugin/Theme loader with condition like:

```php
your_prefix_appsumo()->is_activated();
```

Example:

```php
if ( your_prefix_appsumo()->is_activated() ) {
    add_action( 'plugins_loaded', 'your_prefix_init' );
    function your_prefix_init() {
        require_once dirname( __FILE__ ) . '/includes/init.php';
    }
}
```

### Freemius Friendly

If your Plugin/Theme is already integrated, you can just add few more conditional lines.
Below is an example of MasterStudy Pro plugin.

Before:

```php
function mslms_verify() {
    if ( function_exists( 'mslms_fs' ) ) {
        return ( mslms_fs()->is__premium_only() && mslms_fs()->can_use_premium_code() );
    }
    
    return true;
}
```

After:

```php
function mslms_verify() {
    if ( function_exists( 'mslms_fs' ) ) {
        return ( mslms_fs()->is__premium_only() && mslms_fs()->can_use_premium_code() );
    } elseif ( function_exists( 'mslms_appsumo' ) ) {
        return mslms_appsumo()->is_activated();
    }
    
    return true;
}
```

## Pipeline for Release

Lastly, you have to setup your Project Release Pipelines in order to build AppSumo version of the Plugin/Theme.

Here is an example:

```bash
- step:
  name: Build AppSumo version
  script:
    - rm -rf dist/
    - *variables
    - *init_release
    - .scripts/build.sh
    - git clone git@bitbucket.org:stylemixthemes/appsumo.git
    - *package
    - mv dist/${RELEASE} dist/${BASE}-${VERSION}-appsumo.zip
    - export RELEASE=${BASE}-${VERSION}-appsumo.zip
    - *2downloads
    - rm -rf dist/
```
