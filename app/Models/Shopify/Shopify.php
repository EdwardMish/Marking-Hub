<?php

namespace App\Models\Shopify;

use App\Models\Campaign\Campaigns;
use App\Models\User\SocialProviders;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Shopify
{

    public function validateRequestor(Request $request) {

        $hmac = $request->header('X-Shopify-Hmac-SHA256');
        if (!$hmac)
            return false;
        $shopifySecret = config('service.shopify.client_secret');
        $body = $request->getContent();
        $calculated_hmac = base64_encode(hash_hmac('sha256', $body, $shopifySecret, true));
        return hash_equals($hmac, $calculated_hmac);

    }

    public function addTrackingPixel($accessToken, $storeName)
    {
        $client = new Client();
        $apiV = config('services.shopify.api_version');
        $res = $client->request('POST', 'https://'.$storeName.'/admin/api/'.$apiV.'/script_tags.json', [
            'headers' => ['X-Shopify-Access-Token' => $accessToken],
            'json' => [
                'script_tag' => [
                    'src' => config('services.shopify.script_tag'),
                    'event' => 'onload'
                ]
            ]
        ]);

        return $res;
    }

    public function getOrders(SocialProviders $social, $sinceDateTime, $limit = 50)
    {
        $client = new Client();
        $apiV = config('services.shopify.api_version');
        $res = json_decode($client->request('GET',
            'https://'.$social->nickname.'/admin/api/'.$apiV.'/orders.json?limit='.$limit.'&updated_at_min='.$sinceDateTime, [
                'headers' => ['X-Shopify-Access-Token' => $social->access_token],
            ])->getBody());

        $faker = json_decode('{
  "orders": [
    {
      "id": 450789469,
      "admin_graphql_api_id": "gid://shopify/Order/450789469",
      "app_id": null,
      "browser_ip": "0.0.0.0",
      "buyer_accepts_marketing": false,
      "cancel_reason": null,
      "cancelled_at": null,
      "cart_token": "68778783ad298f1c80c3bafcddeea02f",
      "checkout_id": 901414060,
      "checkout_token": "bd5a8aa1ecd019dd3520ff791ee3a24c",
      "client_details": {
        "accept_language": null,
        "browser_height": null,
        "browser_ip": "0.0.0.0",
        "browser_width": null,
        "session_hash": null,
        "user_agent": null
      },
      "closed_at": null,
      "confirmed": true,
      "contact_email": "bob.norman@hostmail.com",
      "created_at": "2008-01-10T11:00:00-05:00",
      "currency": "USD",
      "customer_locale": null,
      "device_id": null,
      "discount_codes": [
        {
          "code": "TENOFF",
          "amount": "10.00",
          "type": "fixed_amount"
        }
      ],
      "email": "bob.norman@hostmail.com",
      "financial_status": "partially_refunded",
      "fulfillment_status": null,
      "gateway": "authorize_net",
      "landing_site": "http://www.example.com?source=abc",
      "landing_site_ref": "abc",
      "location_id": null,
      "name": "#1001",
      "note": null,
      "note_attributes": [
        {
          "name": "custom engraving",
          "value": "Happy Birthday"
        },
        {
          "name": "colour",
          "value": "green"
        }
      ],
      "number": 1,
      "order_number": 1001,
      "order_status_url": "https://apple.myshopify.com/690933842/orders/b1946ac92492d2347c6235b4d2611184/authenticate?key=imasecretipod",
      "payment_gateway_names": [
        "bogus"
      ],
      "phone": "+557734881234",
      "presentment_currency": "USD",
      "processed_at": "2008-01-10T11:00:00-05:00",
      "processing_method": "direct",
      "reference": "fhwdgads",
      "referring_site": "http://www.otherexample.com",
      "source_identifier": "fhwdgads",
      "source_name": "web",
      "source_url": null,
      "subtotal_price": "597.00",
      "subtotal_price_set": {
        "shop_money": {
          "amount": "597.00",
          "currency_code": "USD"
        },
        "presentment_money": {
          "amount": "597.00",
          "currency_code": "USD"
        }
      },
      "tags": "",
      "tax_lines": [
        {
          "price": "11.94",
          "rate": 0.06,
          "title": "State Tax",
          "price_set": {
            "shop_money": {
              "amount": "11.94",
              "currency_code": "USD"
            },
            "presentment_money": {
              "amount": "11.94",
              "currency_code": "USD"
            }
          }
        }
      ],
      "taxes_included": false,
      "test": false,
      "token": "b1946ac92492d2347c6235b4d2611184",
      "total_discounts": "10.00",
      "total_discounts_set": {
        "shop_money": {
          "amount": "10.00",
          "currency_code": "USD"
        },
        "presentment_money": {
          "amount": "10.00",
          "currency_code": "USD"
        }
      },
      "total_line_items_price": "597.00",
      "total_line_items_price_set": {
        "shop_money": {
          "amount": "597.00",
          "currency_code": "USD"
        },
        "presentment_money": {
          "amount": "597.00",
          "currency_code": "USD"
        }
      },
      "total_price": "598.94",
      "total_price_set": {
        "shop_money": {
          "amount": "598.94",
          "currency_code": "USD"
        },
        "presentment_money": {
          "amount": "598.94",
          "currency_code": "USD"
        }
      },
      "total_price_usd": "598.94",
      "total_shipping_price_set": {
        "shop_money": {
          "amount": "0.00",
          "currency_code": "USD"
        },
        "presentment_money": {
          "amount": "0.00",
          "currency_code": "USD"
        }
      },
      "total_tax": "11.94",
      "total_tax_set": {
        "shop_money": {
          "amount": "11.94",
          "currency_code": "USD"
        },
        "presentment_money": {
          "amount": "11.94",
          "currency_code": "USD"
        }
      },
      "total_tip_received": "0.00",
      "total_weight": 0,
      "updated_at": "2008-01-10T11:00:00-05:00",
      "user_id": null,
      "billing_address": {
        "first_name": "Bob",
        "address1": "Chestnut Street 92",
        "phone": "555-625-1199",
        "city": "Louisville",
        "zip": "40202",
        "province": "Kentucky",
        "country": "United States",
        "last_name": "Norman",
        "address2": "",
        "company": null,
        "latitude": 45.41634,
        "longitude": -75.6868,
        "name": "Bob Norman",
        "country_code": "US",
        "province_code": "KY"
      },
      "customer": {
        "id": 207119551,
        "email": "bob.norman@hostmail.com",
        "accepts_marketing": false,
        "created_at": "2021-10-01T17:01:53-04:00",
        "updated_at": "2021-10-01T17:01:53-04:00",
        "first_name": "Bob",
        "last_name": "Norman",
        "orders_count": 1,
        "state": "disabled",
        "total_spent": "199.65",
        "last_order_id": 450789469,
        "note": null,
        "verified_email": true,
        "multipass_identifier": null,
        "tax_exempt": false,
        "phone": "+16136120707",
        "tags": "",
        "last_order_name": "#1001",
        "currency": "USD",
        "accepts_marketing_updated_at": "2005-06-12T11:57:11-04:00",
        "marketing_opt_in_level": null,
        "tax_exemptions": [],
        "admin_graphql_api_id": "gid://shopify/Customer/207119551",
        "default_address": {
          "id": 207119551,
          "customer_id": 207119551,
          "first_name": null,
          "last_name": null,
          "company": null,
          "address1": "Chestnut Street 92",
          "address2": "",
          "city": "Louisville",
          "province": "Kentucky",
          "country": "United States",
          "zip": "40202",
          "phone": "555-625-1199",
          "name": "",
          "province_code": "KY",
          "country_code": "US",
          "country_name": "United States",
          "default": true
        }
      },
      "discount_applications": [
        {
          "target_type": "line_item",
          "type": "discount_code",
          "value": "10.0",
          "value_type": "fixed_amount",
          "allocation_method": "across",
          "target_selection": "all",
          "code": "TENOFF"
        }
      ],
      "fulfillments": [
        {
          "id": 255858046,
          "admin_graphql_api_id": "gid://shopify/Fulfillment/255858046",
          "created_at": "2021-10-01T17:01:53-04:00",
          "location_id": 905684977,
          "name": "#1001.0",
          "order_id": 450789469,
          "receipt": {
            "testcase": true,
            "authorization": "123456"
          },
          "service": "manual",
          "shipment_status": null,
          "status": "failure",
          "tracking_company": "USPS",
          "tracking_number": "1Z2345",
          "tracking_numbers": [
            "1Z2345"
          ],
          "tracking_url": "https://tools.usps.com/go/TrackConfirmAction_input?qtc_tLabels1=1Z2345",
          "tracking_urls": [
            "https://tools.usps.com/go/TrackConfirmAction_input?qtc_tLabels1=1Z2345"
          ],
          "updated_at": "2021-10-01T17:01:53-04:00",
          "line_items": [
            {
              "id": 466157049,
              "admin_graphql_api_id": "gid://shopify/LineItem/466157049",
              "fulfillable_quantity": 0,
              "fulfillment_service": "manual",
              "fulfillment_status": null,
              "gift_card": false,
              "grams": 200,
              "name": "IPod Nano - 8gb - green",
              "price": "199.00",
              "price_set": {
                "shop_money": {
                  "amount": "199.00",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "199.00",
                  "currency_code": "USD"
                }
              },
              "product_exists": true,
              "product_id": 632910392,
              "properties": [
                {
                  "name": "Custom Engraving Front",
                  "value": "Happy Birthday"
                },
                {
                  "name": "Custom Engraving Back",
                  "value": "Merry Christmas"
                }
              ],
              "quantity": 1,
              "requires_shipping": true,
              "sku": "IPOD2008GREEN",
              "taxable": true,
              "title": "IPod Nano - 8gb",
              "total_discount": "0.00",
              "total_discount_set": {
                "shop_money": {
                  "amount": "0.00",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "0.00",
                  "currency_code": "USD"
                }
              },
              "variant_id": 39072856,
              "variant_inventory_management": "shopify",
              "variant_title": "green",
              "vendor": null,
              "tax_lines": [
                {
                  "price": "3.98",
                  "price_set": {
                    "shop_money": {
                      "amount": "3.98",
                      "currency_code": "USD"
                    },
                    "presentment_money": {
                      "amount": "3.98",
                      "currency_code": "USD"
                    }
                  },
                  "rate": 0.06,
                  "title": "State Tax"
                }
              ],
              "discount_allocations": [
                {
                  "amount": "3.34",
                  "amount_set": {
                    "shop_money": {
                      "amount": "3.34",
                      "currency_code": "USD"
                    },
                    "presentment_money": {
                      "amount": "3.34",
                      "currency_code": "USD"
                    }
                  },
                  "discount_application_index": 0
                }
              ]
            }
          ]
        }
      ],
      "line_items": [
        {
          "id": 466157049,
          "admin_graphql_api_id": "gid://shopify/LineItem/466157049",
          "fulfillable_quantity": 0,
          "fulfillment_service": "manual",
          "fulfillment_status": null,
          "gift_card": false,
          "grams": 200,
          "name": "IPod Nano - 8gb - green",
          "price": "199.00",
          "price_set": {
            "shop_money": {
              "amount": "199.00",
              "currency_code": "USD"
            },
            "presentment_money": {
              "amount": "199.00",
              "currency_code": "USD"
            }
          },
          "product_exists": true,
          "product_id": 632910392,
          "properties": [
            {
              "name": "Custom Engraving Front",
              "value": "Happy Birthday"
            },
            {
              "name": "Custom Engraving Back",
              "value": "Merry Christmas"
            }
          ],
          "quantity": 1,
          "requires_shipping": true,
          "sku": "IPOD2008GREEN",
          "taxable": true,
          "title": "IPod Nano - 8gb",
          "total_discount": "0.00",
          "total_discount_set": {
            "shop_money": {
              "amount": "0.00",
              "currency_code": "USD"
            },
            "presentment_money": {
              "amount": "0.00",
              "currency_code": "USD"
            }
          },
          "variant_id": 39072856,
          "variant_inventory_management": "shopify",
          "variant_title": "green",
          "vendor": null,
          "tax_lines": [
            {
              "price": "3.98",
              "price_set": {
                "shop_money": {
                  "amount": "3.98",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "3.98",
                  "currency_code": "USD"
                }
              },
              "rate": 0.06,
              "title": "State Tax"
            }
          ],
          "discount_allocations": [
            {
              "amount": "3.34",
              "amount_set": {
                "shop_money": {
                  "amount": "3.34",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "3.34",
                  "currency_code": "USD"
                }
              },
              "discount_application_index": 0
            }
          ]
        },
        {
          "id": 518995019,
          "admin_graphql_api_id": "gid://shopify/LineItem/518995019",
          "fulfillable_quantity": 1,
          "fulfillment_service": "manual",
          "fulfillment_status": null,
          "gift_card": false,
          "grams": 200,
          "name": "IPod Nano - 8gb - red",
          "price": "199.00",
          "price_set": {
            "shop_money": {
              "amount": "199.00",
              "currency_code": "USD"
            },
            "presentment_money": {
              "amount": "199.00",
              "currency_code": "USD"
            }
          },
          "product_exists": true,
          "product_id": 632910392,
          "properties": [],
          "quantity": 1,
          "requires_shipping": true,
          "sku": "IPOD2008RED",
          "taxable": true,
          "title": "IPod Nano - 8gb",
          "total_discount": "0.00",
          "total_discount_set": {
            "shop_money": {
              "amount": "0.00",
              "currency_code": "USD"
            },
            "presentment_money": {
              "amount": "0.00",
              "currency_code": "USD"
            }
          },
          "variant_id": 49148385,
          "variant_inventory_management": "shopify",
          "variant_title": "red",
          "vendor": null,
          "tax_lines": [
            {
              "price": "3.98",
              "price_set": {
                "shop_money": {
                  "amount": "3.98",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "3.98",
                  "currency_code": "USD"
                }
              },
              "rate": 0.06,
              "title": "State Tax"
            }
          ],
          "discount_allocations": [
            {
              "amount": "3.33",
              "amount_set": {
                "shop_money": {
                  "amount": "3.33",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "3.33",
                  "currency_code": "USD"
                }
              },
              "discount_application_index": 0
            }
          ]
        },
        {
          "id": 703073504,
          "admin_graphql_api_id": "gid://shopify/LineItem/703073504",
          "fulfillable_quantity": 0,
          "fulfillment_service": "manual",
          "fulfillment_status": null,
          "gift_card": false,
          "grams": 200,
          "name": "IPod Nano - 8gb - black",
          "price": "199.00",
          "price_set": {
            "shop_money": {
              "amount": "199.00",
              "currency_code": "USD"
            },
            "presentment_money": {
              "amount": "199.00",
              "currency_code": "USD"
            }
          },
          "product_exists": true,
          "product_id": 632910392,
          "properties": [],
          "quantity": 1,
          "requires_shipping": true,
          "sku": "IPOD2008BLACK",
          "taxable": true,
          "title": "IPod Nano - 8gb",
          "total_discount": "0.00",
          "total_discount_set": {
            "shop_money": {
              "amount": "0.00",
              "currency_code": "USD"
            },
            "presentment_money": {
              "amount": "0.00",
              "currency_code": "USD"
            }
          },
          "variant_id": 457924702,
          "variant_inventory_management": "shopify",
          "variant_title": "black",
          "vendor": null,
          "tax_lines": [
            {
              "price": "3.98",
              "price_set": {
                "shop_money": {
                  "amount": "3.98",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "3.98",
                  "currency_code": "USD"
                }
              },
              "rate": 0.06,
              "title": "State Tax"
            }
          ],
          "discount_allocations": [
            {
              "amount": "3.33",
              "amount_set": {
                "shop_money": {
                  "amount": "3.33",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "3.33",
                  "currency_code": "USD"
                }
              },
              "discount_application_index": 0
            }
          ]
        }
      ],
      "payment_details": {
        "credit_card_bin": null,
        "avs_result_code": null,
        "cvv_result_code": null,
        "credit_card_number": "•••• •••• •••• 4242",
        "credit_card_company": "Visa"
      },
      "refunds": [
        {
          "id": 509562969,
          "admin_graphql_api_id": "gid://shopify/Refund/509562969",
          "created_at": "2021-10-01T17:01:53-04:00",
          "note": "it broke during shipping",
          "order_id": 450789469,
          "processed_at": "2021-10-01T17:01:53-04:00",
          "restock": true,
          "user_id": 799407056,
          "order_adjustments": [],
          "transactions": [
            {
              "id": 179259969,
              "admin_graphql_api_id": "gid://shopify/OrderTransaction/179259969",
              "amount": "209.00",
              "authorization": "authorization-key",
              "created_at": "2005-08-05T12:59:12-04:00",
              "currency": "USD",
              "device_id": null,
              "error_code": null,
              "gateway": "bogus",
              "kind": "refund",
              "location_id": null,
              "message": null,
              "order_id": 450789469,
              "parent_id": 801038806,
              "processed_at": "2005-08-05T12:59:12-04:00",
              "receipt": {},
              "source_name": "web",
              "status": "success",
              "test": false,
              "user_id": null
            }
          ],
          "refund_line_items": [
            {
              "id": 104689539,
              "line_item_id": 703073504,
              "location_id": 487838322,
              "quantity": 1,
              "restock_type": "legacy_restock",
              "subtotal": 195.66,
              "subtotal_set": {
                "shop_money": {
                  "amount": "195.66",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "195.66",
                  "currency_code": "USD"
                }
              },
              "total_tax": 3.98,
              "total_tax_set": {
                "shop_money": {
                  "amount": "3.98",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "3.98",
                  "currency_code": "USD"
                }
              },
              "line_item": {
                "id": 703073504,
                "admin_graphql_api_id": "gid://shopify/LineItem/703073504",
                "fulfillable_quantity": 0,
                "fulfillment_service": "manual",
                "fulfillment_status": null,
                "gift_card": false,
                "grams": 200,
                "name": "IPod Nano - 8gb - black",
                "price": "199.00",
                "price_set": {
                  "shop_money": {
                    "amount": "199.00",
                    "currency_code": "USD"
                  },
                  "presentment_money": {
                    "amount": "199.00",
                    "currency_code": "USD"
                  }
                },
                "product_exists": true,
                "product_id": 632910392,
                "properties": [],
                "quantity": 1,
                "requires_shipping": true,
                "sku": "IPOD2008BLACK",
                "taxable": true,
                "title": "IPod Nano - 8gb",
                "total_discount": "0.00",
                "total_discount_set": {
                  "shop_money": {
                    "amount": "0.00",
                    "currency_code": "USD"
                  },
                  "presentment_money": {
                    "amount": "0.00",
                    "currency_code": "USD"
                  }
                },
                "variant_id": 457924702,
                "variant_inventory_management": "shopify",
                "variant_title": "black",
                "vendor": null,
                "tax_lines": [
                  {
                    "price": "3.98",
                    "price_set": {
                      "shop_money": {
                        "amount": "3.98",
                        "currency_code": "USD"
                      },
                      "presentment_money": {
                        "amount": "3.98",
                        "currency_code": "USD"
                      }
                    },
                    "rate": 0.06,
                    "title": "State Tax"
                  }
                ],
                "discount_allocations": [
                  {
                    "amount": "3.33",
                    "amount_set": {
                      "shop_money": {
                        "amount": "3.33",
                        "currency_code": "USD"
                      },
                      "presentment_money": {
                        "amount": "3.33",
                        "currency_code": "USD"
                      }
                    },
                    "discount_application_index": 0
                  }
                ]
              }
            },
            {
              "id": 709875399,
              "line_item_id": 466157049,
              "location_id": 487838322,
              "quantity": 1,
              "restock_type": "legacy_restock",
              "subtotal": 195.67,
              "subtotal_set": {
                "shop_money": {
                  "amount": "195.67",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "195.67",
                  "currency_code": "USD"
                }
              },
              "total_tax": 3.98,
              "total_tax_set": {
                "shop_money": {
                  "amount": "3.98",
                  "currency_code": "USD"
                },
                "presentment_money": {
                  "amount": "3.98",
                  "currency_code": "USD"
                }
              },
              "line_item": {
                "id": 466157049,
                "admin_graphql_api_id": "gid://shopify/LineItem/466157049",
                "fulfillable_quantity": 0,
                "fulfillment_service": "manual",
                "fulfillment_status": null,
                "gift_card": false,
                "grams": 200,
                "name": "IPod Nano - 8gb - green",
                "price": "199.00",
                "price_set": {
                  "shop_money": {
                    "amount": "199.00",
                    "currency_code": "USD"
                  },
                  "presentment_money": {
                    "amount": "199.00",
                    "currency_code": "USD"
                  }
                },
                "product_exists": true,
                "product_id": 632910392,
                "properties": [
                  {
                    "name": "Custom Engraving Front",
                    "value": "Happy Birthday"
                  },
                  {
                    "name": "Custom Engraving Back",
                    "value": "Merry Christmas"
                  }
                ],
                "quantity": 1,
                "requires_shipping": true,
                "sku": "IPOD2008GREEN",
                "taxable": true,
                "title": "IPod Nano - 8gb",
                "total_discount": "0.00",
                "total_discount_set": {
                  "shop_money": {
                    "amount": "0.00",
                    "currency_code": "USD"
                  },
                  "presentment_money": {
                    "amount": "0.00",
                    "currency_code": "USD"
                  }
                },
                "variant_id": 39072856,
                "variant_inventory_management": "shopify",
                "variant_title": "green",
                "vendor": null,
                "tax_lines": [
                  {
                    "price": "3.98",
                    "price_set": {
                      "shop_money": {
                        "amount": "3.98",
                        "currency_code": "USD"
                      },
                      "presentment_money": {
                        "amount": "3.98",
                        "currency_code": "USD"
                      }
                    },
                    "rate": 0.06,
                    "title": "State Tax"
                  }
                ],
                "discount_allocations": [
                  {
                    "amount": "3.34",
                    "amount_set": {
                      "shop_money": {
                        "amount": "3.34",
                        "currency_code": "USD"
                      },
                      "presentment_money": {
                        "amount": "3.34",
                        "currency_code": "USD"
                      }
                    },
                    "discount_application_index": 0
                  }
                ]
              }
            }
          ]
        }
      ],
      "shipping_address": {
        "first_name": "Bob",
        "address1": "Chestnut Street 92",
        "phone": "555-625-1199",
        "city": "Louisville",
        "zip": "40202",
        "province": "Kentucky",
        "country": "United States",
        "last_name": "Norman",
        "address2": "",
        "company": null,
        "latitude": 45.41634,
        "longitude": -75.6868,
        "name": "Bob Norman",
        "country_code": "US",
        "province_code": "KY"
      },
      "shipping_lines": [
        {
          "id": 369256396,
          "carrier_identifier": null,
          "code": "Free Shipping",
          "delivery_category": null,
          "discounted_price": "0.00",
          "discounted_price_set": {
            "shop_money": {
              "amount": "0.00",
              "currency_code": "USD"
            },
            "presentment_money": {
              "amount": "0.00",
              "currency_code": "USD"
            }
          },
          "phone": null,
          "price": "0.00",
          "price_set": {
            "shop_money": {
              "amount": "0.00",
              "currency_code": "USD"
            },
            "presentment_money": {
              "amount": "0.00",
              "currency_code": "USD"
            }
          },
          "requested_fulfillment_service_id": null,
          "source": "shopify",
          "title": "Free Shipping",
          "tax_lines": [],
          "discount_allocations": []
        }
      ]
    }
  ]
}');

        return $faker->orders;
    }

    public function getAbandonCart(SocialProviders $social, $sinceDateTime)
    {
        $client = new Client();
        $apiV = config('services.shopify.api_version');
        $res = json_decode($client->request('GET',
            'https://'.$social->nickname.'/admin/api/'.$apiV.'/checkouts.json?created_at_min='.$sinceDateTime, [
                'headers' => ['X-Shopify-Access-Token' => $social->access_token],
            ])->getBody());

        return $res->checkouts;
    }

    public function submitPriceRule(SocialProviders $social, $deal)
    {
        $client = new Client();
        $apiV = config('services.shopify.api_version');
        $discountType = '';
        $title = $deal['discount_prefix'];

        //Get rid of the $/%
        // Shopify wants a BigDecimal, and it needs to be negative
        $discountAmount = -1 * floatval(preg_replace("/[^0-9.]/", "", $deal['discount_amount']));

        if ($deal['discount_type'] == 1) {
            $discountType = 'percentage';
            $title = strtoupper($title.$discountAmount.'PERCENTOFF');
        } elseif ($deal['discount_type'] == 2) {
            $discountType = 'fixed_amount';
            $title = strtoupper($title.$discountAmount.'OFF');
        }

        $startsAt = (new \DateTime())->format(\DateTime::ATOM);

        //Send the price rule to Shopify
        $res = $client->request('POST', 'https://'.$social->nickname.'/admin/api/'.$apiV.'/price_rules.json', [
            'headers' => ['X-Shopify-Access-Token' => $social->access_token],
            'json' => [
                "price_rule" => [
                    "title" => $title,
                    "target_type" => "line_item",
                    "target_selection" => "all",
                    "allocation_method" => "across",
                    "value_type" => $discountType,
                    "value" => $discountAmount,
                    "customer_selection" => "all",
                    "starts_at" => $startsAt
                ]
            ]
        ]);

        return json_decode($res->getBody());
    }

    public function submitDiscountCode(SocialProviders $social, Campaigns $campaign, $discountCode)
    {
        $client = new Client();
        $apiV = config('services.shopify.api_version');

        $res = $client->request(
            'POST',
            'https://'.$social->nickname.'/admin/api/'.$apiV.'/price_rules/'.$campaign->discount_price_rule_id.'/discount_codes.json',
            [
                'headers' => ['X-Shopify-Access-Token' => $social->access_token],
                'json' => [
                    "discount_code" => [
                        "code" => $discountCode
                    ]
                ]
            ]);

        return json_decode($res->getBody());
    }
}
