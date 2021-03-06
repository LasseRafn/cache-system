<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 13/12/18
	 * Time: 22.26
	 */

	namespace CacheSystem\Traits;

	trait SerializeHelpers
	{
		/**
		 * Class of Serializer to use
		 *
		 * @var
		 */
		private $serializer;

		/**
		 * @param      $rawData
		 * @param bool $DETECT_SERIALIZER
		 *
		 * @return mixed
		 * @throws \Exception
		 */
		protected function _unserializeData($rawData, bool $DETECT_SERIALIZER = true)
		{
			$this->_setRawData($rawData);

			if (true === $DETECT_SERIALIZER)
				$this->_detectSerializer();

			$data = $this->serializer->get($rawData);

			return $data;
		}

		/**
		 * Detect serializer of get cache and _set serializer attr
		 *
		 * @param $data
		 */
		protected function _detectSerializer(): void
		{
			$serializer_of_cache = $this->getSerializer();

			if (NULL === $serializer_of_cache)
				return;
			else if ($serializer_of_cache !== get_class($this->serializer))
				$this->_setSerializer($serializer_of_cache);
		}

		/**
		 * @param $data
		 *
		 * @return mixed
		 * @throws \Exception
		 */
		protected function _serializeData($data): ?string
		{
			$rawData = $this->serializer->make($data);
			$this->_setRawData($rawData);
			return $rawData;
		}

		protected function _getCacheSerializer()
		{
			return $this->serializer;
		}

		/**
		 * Private function to _set Serializer
		 *
		 * @param $serializer
		 */
		protected function _setSerializer(string $serializer): void
		{
			if (!class_exists($serializer))
				throw new \Exception("Error serializer not exist");

			$this->serializer = new $serializer;
		}
	}