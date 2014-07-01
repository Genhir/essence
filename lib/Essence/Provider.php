<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace Essence;

use Essence\Configurable;
use Essence\Exception;
use Essence\Media;
use Essence\Provider\Filters;



/**
 *	Base class for a Provider.
 */

abstract class Provider {

	use Configurable;



	/**
	 *	Preparators.
	 *
	 *	@var Essence\Provider\Filters
	 */

	protected $_Preparators = null;



	/**
	 *	Presenters.
	 *
	 *	@var Essence\Provider\Filters
	 */

	protected $_Presenters = null;



	/**
	 *	Configuration options.
	 *
	 *	@var array
	 */

	protected $_properties = [ ];



	/**
	 *	Constructor.
	 *
	 *	@param array $preparators Preparators.
	 *	@param array $presenters Presenters.
	 */

	public function __construct(
		array $preparators = [ ],
		array $presenters = [ ]
	) {
		$this->_Preparators = new Filters( $preparators );
		$this->_Presenters = new Filters( $presenters );
	}



	/**
	 *	Fetches embed information from the given URL.
	 *
	 *	@param string $url URL to fetch informations from.
	 *	@param array $options Custom options to be interpreted by the provider.
	 *	@return Media|null Embed informations, or null if nothing could be
	 *		fetched.
	 */

	public final function embed( $url, array $options = [ ]) {

		$this->_Preparators->filter( $url );

		$Media = $this->_embed( $url, $options );
		$Media->setDefault( 'url', $url );

		return $this->_Presenters->filter( $Media );
	}



	/**
	 *	Does the actual fetching of informations.
	 *
	 *	@param string $url URL to fetch informations from.
	 *	@param array $options Custom options to be interpreted by the provider.
	 *	@return Media Embed informations.
	 *	@throws Essence\Exception
	 */

	abstract protected function _embed( $url, array $options );

}
