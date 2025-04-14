<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class HotelTravelGate extends Controller
{
    //

    public function searchHotelsGeo(Request $request)
{
    $destination = $request->input('destination'); // Obtener el destino desde el request

    if (!$destination) {
        return response()->json(['error' => 'El destino es requerido'], 400);
    }
    $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($destination) . "&format=json&limit=1";

    // API Key de OpenCage desde .env
    $response = Http::withHeaders([
        'User-Agent' => 'Mozilla/5.0 (Laravel App)', // Indica que la petición es de un navegador
    ])->get($url);

    $data = $response->json();
    if (!$response) {
        return response()->json(['error' => 'No se encontraron coordenadas para el destino'], 404);
    }

    // Extraer latitud y longitud

    $latitude = $data[0]['lat'];
    $longitude = $data[0]['lon'];

    // Construir la consulta GraphQL
    $query = [
        'query' => '
        query {
            inventory {
                searchHotelsMaster(
                    hotelsMasterSearchFilterInput: {
                        geoCoordinates: {
                            latitude: '.$latitude.',
                            longitude: '.$longitude.',
                            radiusKm: 20
                        },
                        hotelName: ""
                    }
                ) {
                    hotels {
                        id
                        name
                        address
                        postalCode
                        latitude
                        longitude
                        category {
                            id
                            name
                        }
                        locality {
                            id
                            name
                            countryCode
                        }
                        hotelCode
                        contextCode
                    }
                    success
                    adviseMessages {
                        code
                        description
                    }
                }
            }
        }'
    ];

    // Realizar la petición a TravelGateX
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Apikey test0000-0000-0000-0000-000000000000',
        'Content-Type' => 'application/json',    ])->post('https://api.travelgatex.com', $query);

    return $response->json();
}


    public function searchHotels()
    {
        // Query GraphQL COMPLETA (static)
        $query = <<<'GRAPHQL'
        query (
            $criteriaSearch: HotelCriteriaSearchInput,
            $settings: HotelSettingsInput,
            $filterSearch: HotelXFilterSearchInput
        ) {
            hotelX {
                search(
                    criteria: $criteriaSearch
                    settings: $settings
                    filterSearch: $filterSearch
                ) {
                    context
                    options {
                        id
                        accessCode
                        supplierCode
                        hotelCode
                        hotelName
                        boardCode
                        paymentType
                        status
                        occupancies {
                            id
                            paxes {
                                age
                            }
                        }
                        rooms {
                            occupancyRefId
                            code
                            description
                            refundable
                            roomPrice {
                                price {
                                    currency
                                    binding
                                    net
                                    gross
                                    exchange {
                                        currency
                                        rate
                                    }
                                }
                                breakdown {
                                    start
                                    end
                                    price {
                                        currency
                                        binding
                                        net
                                        gross
                                        exchange {
                                            currency
                                            rate
                                        }
                                        minimumSellingPrice
                                    }
                                }
                            }
                            beds {
                                type
                                count
                            }
                            ratePlans {
                                start
                                end
                                code
                                name
                            }
                            promotions{
                                start
                                end
                                code
                                name
                            }
                        }
                        price {
                            currency
                            binding
                            net
                            gross
                            exchange {
                                currency
                                rate
                            }
                            minimumSellingPrice
                            markups {
                                channel
                                currency
                                binding
                                net
                                gross
                                exchange {
                                    currency
                                    rate
                                }
                                rules {
                                    id
                                    name
                                    type
                                    value
                                }
                            }
                        }
                        supplements {
                            start
                            end
                            code
                            name
                            description
                            supplementType
                            chargeType
                            mandatory
                            durationType
                            quantity
                            unit
                            resort {
                                code
                                name
                                description
                            }
                            price {
                                currency
                                binding
                                net
                                gross
                                exchange {
                                    currency
                                    rate
                                }
                            }
                        }
                        surcharges {
                            code
                            chargeType
                            description
                            mandatory
                            price {
                                currency
                                binding
                                net
                                gross
                                exchange {
                                    currency
                                    rate
                                }
                                markups {
                                    channel
                                    currency
                                    binding
                                    net
                                    gross
                                    exchange {
                                        currency
                                        rate
                                    }
                                }
                            }
                        }
                        rateRules
                        cancelPolicy {
                            refundable
                            cancelPenalties {
                                deadline
                                isCalculatedDeadline
                                penaltyType
                                currency
                                value
                            }
                        }
                        remarks
                    }
                    errors {
                        code
                        type
                        description
                    }
                    warnings {
                        code
                        type
                        description
                    }
                }
            }
        }
        GRAPHQL;

        // Variables HARDCODEADAS según tu JSON
        $variables = [
            "criteriaSearch" => [
                "checkIn" => "2025-04-28",
                "checkOut" => "2025-04-29",
                "occupancies" => [
                    [
                        "paxes" => [
                            ["age" => 30],
                            ["age" => 30]
                        ]
                    ]
                ],
                "hotels" => ["1"],
                "currency" => "EUR",
                "markets" => ["ES"],
                "language" => "es",
                "nationality" => "ES"
            ],
            "settings" => [
                "client" => "client_demo",
                "context" => "HOTELTEST",
                "testMode" => true,
                "timeout" => 25000
            ],
            "filterSearch" => [
                "access" => [
                    "includes" => ["2"]
                ]
            ]
        ];

        // Enviar request a la API
        $response = Http::withHeaders([
            'Authorization' => 'Apikey test0000-0000-0000-0000-000000000000',
            'Content-Type' => 'application/json',
        ])->post('https://api.travelgatex.com', [
            'query' => $query,
            'variables' => $variables
        ]);

        // Manejar respuesta
        return $response->successful()
            ? response()->json($response->json())
            : response()->json([
                'error' => 'Hotel search failed',
                'details' => $response->json()
            ], $response->status());
    }

    public function getAllDestinations()
{
    // Query GraphQL COMPLETA (static)
    // Query GraphQL COMPLETA (static)
    $query = <<<GRAPHQL
    query {
        hotelX {
            destinations(criteria: {
                access: "2",
                maxSize: 500,

            }) {
                token
                edges {
                    node {
                        code
                        destinationData {
                            code
                            texts {
                                text
                                language
                            }
                            type
                        }
                    }
                }
            }
        }
    }
    GRAPHQL;

// Variables HARDCODEADAS según necesidades
$variables = [
    "token" => "",
    "criteria" => [
        "access" => "2",  // Acceso de prueba
        "maxSize" => 500
    ]
];

// Enviar request a la API
$response = Http::withHeaders([
    'Authorization' => 'Apikey test0000-0000-0000-0000-000000000000',
    'Content-Type' => 'application/json',
])->post('https://api.travelgatex.com', [
    'query' => $query,
    'variables' => $variables
]);

    // Manejar respuesta
    return $response->successful()
        ? response()->json($response->json())
        : response()->json([
            'error' => 'Destination search failed',
            'details' => $response->json()
        ], $response->status());
}

// Función 1: introspección del esquema
public function introspect()
{
    $query = <<<GQL
    {
        __schema {
            mutationType {
                fields {
                    name
                    args {
                        name
                        type {
                            kind
                            name
                            ofType {
                                kind
                                name
                            }
                        }
                    }
                }
            }
        }
    }
    GQL;

    $response = Http::withHeaders([
        'Authorization' => 'Apikey test0000-0000-0000-0000-000000000000',
        'Content-Type' => 'application/json',
    ])->post('https://api.travelgatex.com', [
        'query' => $query
    ]);

    return response()->json($response->json(), $response->status());
}

// Función 2: buscar disponibilidad (cuando sepamos la mutación y el input correcto)
public function searchDisponibility()
{
    $query = <<<GRAPHQL
    query {
      hotelX {
        search(
          criteria: {
            checkIn: "2023-12-20"
            checkOut: "2023-12-22"
            hotels: ["1", "2", "3"]
            occupancies: [
              {
                paxes: [
                  { age: 30 },
                  { age: 30 }
                ]
              }
            ]
            language: "es"
            nationality: "ES"
            currency: "EUR"
            market: "ES"
          }
          settings: {
            client: "demo_client"
            testMode: true
            context: "HOTELTEST"
            suppliers: [
              {
                code: "demo_supplier"
                settings: {
                  timeout: 15000
                }
              }
            ]
          }
        ) {
          context
          options {
            id
            hotelCode
            hotelName
            boardCode
            price {
              currency
              net
              gross
            }
            rooms {
              code
              name
            }
          }
          errors {
            code
            type
            description
          }
        }
      }
    }
    GRAPHQL;

    $variables = (object)[];

    $response = Http::withHeaders([
        'Authorization' => 'Apikey test0000-0000-0000-0000-000000000000',
        'Content-Type' => 'application/json',
    ])->post('https://api.travelgatex.com', [
        'query' => $query,
        'variables' => $variables
    ]);

    return $response->json();
}

public function introspectSearchCriteria()
{
    $query = <<<GQL
    {
        __type(name: "Mutation") {
            fields {
                name
                args {
                    name
                    type {
                        kind
                        name
                        ofType {
                            kind
                            name
                        }
                    }
                }
            }
        }
    }
    GQL;

    $response = Http::withHeaders([
        'Authorization' => 'Apikey test0000-0000-0000-0000-000000000000',
        'Content-Type' => 'application/json',
    ])->post('https://api.travelgatex.com', [
        'query' => $query
    ]);

    return response()->json($response->json(), $response->status());
}
}


