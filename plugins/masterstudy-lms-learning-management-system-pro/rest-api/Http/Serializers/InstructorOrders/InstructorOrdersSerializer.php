<?php

namespace MasterStudy\Lms\Pro\RestApi\Http\Serializers\InstructorOrders;

use MasterStudy\Lms\Http\Serializers\AbstractSerializer;

final class InstructorOrdersSerializer extends AbstractSerializer {
	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function toArray( $data ): array {
		return array(
			'order_id'     => (int) $data['order_id'],
			'user_info'    => $data['user_info'] ?? '',
			'status_name'  => $data['status_name'] ?? '',
			'total_price'  => $data['total_price'] ?? '',
			'total_items'  => (int) ( $data['total_items'] ?? 0 ),
			'payment_code' => $data['payment_code'] ?? '',
			'date'         => $data['date'] ?? null,
		);
	}
}
