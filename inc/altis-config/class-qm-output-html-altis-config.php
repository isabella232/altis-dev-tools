<?php
/**
 * Altis config data output for HTML pages.
 */

namespace Altis\Dev_Tools;

use function Altis\get_config;
use QM_Collector;
use QM_Output_Html;

class QM_Output_Html_Altis_Config extends QM_Output_Html {

	public function __construct( QM_Collector $collector ) {
		parent::__construct( $collector );
		add_filter( 'qm/output/panel_menus', [ $this, 'panel_menu' ], 50 );
	}

	public function output() {
		$config = get_config()['modules'] ?? [];

		if ( ! $config ) {
			echo esc_html_x( 'Something went wrong with displaying the Altis config settings.', 'Displaying Altis config info in the Query Monitor plugin', 'altis' );
			return;
		}
		?>

		<?php $this->before_tabular_output(); ?>

		<caption>
			<h2><?php echo esc_html( $this->name() ); ?></h2>
		</caption>
		<thead>
		<tr>
			<th><?php echo esc_html__( 'Module', 'altis' ) ?></th>
			<th><?php echo esc_html__( 'Settings', 'altis' ) ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $config as $module => $settings ) : ?>
			<tr>
				<td><?php echo esc_html( $module ) ?></td>
				<td><?php printf( '<pre>%s</pre>', print_r( $settings, true ) ); ?>
			</tr>
		<?php endforeach; ?>
		</tbody>
		<?php
		$this->after_tabular_output();
	}

	/**
	 * Add menu item for Altis Config to the Query Monitor panel menu.
	 *
	 * @param array $menu Array of menus for Query Monitor.
	 *
	 * @return array Array of menus for Query Monitor including Altis Config menu item.
	 */
	public function panel_menu( array $menu ) : array {
		$menu['altis-config']['title'] = $this->name();
		$menu['altis-config']['href']  = '#' . $this->collector->id();
		return $menu;
	}
}
