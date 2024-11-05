<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PropertySeeder extends Seeder
{
    const IMAGE_PATH = 'uploads/properties/';

    public function run(): void
    {
        // Fetch existing users
        $users = User::whereIn('role', ['seller', 'admin', 'agent1', 'agent2'])->get();

        if ($users->isEmpty()) {
            Log::warning("No users found with roles: seller, admin, agent1, agent2. Please seed users first.");
            return;
        }

        // Existing properties (updated with IDs, Peso prices, and new fields)
        $existingProperties = [
            [
                'id' => 1,
                'title' => 'Luxury Villa',
                'description' => 'A beautiful luxury villa with ocean view',
                'price' => 50000000, // 50 million pesos
                'property_type' => 'villa',
                'city' => 'Batangas',
                'beds' => 5,
                'baths' => 4,
                'area_sqm' => 4000,
                'image' => self::IMAGE_PATH . 'property10.jpg',
                'featured' => true,
                'location' => 'Nasugbu, Batangas',
                'property_address' => '123 Tali Beach Drive, Nasugbu, Batangas',
                'bedrooms' => 5,
                'bathrooms' => 4,
                'sqm' => 372,
                'type' => 'house_and_lot',
                'contact_email' => 'luxuryvilla@example.com',
                'contact_messenger' => 'https://m.me/luxuryvilla',
                'contact_whatsapp' => '+639123456789',
                'swimming_pool' => true,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Private beach access, Home theater',
                'lot_size' => 1000,
                'is_featured' => true,
                'is_exclusive' => true,
                'status' => 'for_sale',
            ],
            [
                'id' => 2,
                'title' => 'Downtown Apartment',
                'description' => 'Modern apartment in the heart of the city',
                'price' => 25000000, // 25 million pesos
                'property_type' => 'apartment',
                'city' => 'Makati',
                'beds' => 2,
                'baths' => 2,
                'area_sqm' => 1200,
                'image' => self::IMAGE_PATH . 'property11.jpg',
                'featured' => false,
                'location' => 'Makati, Metro Manila',
                'property_address' => '456 Ayala Avenue, Makati City, 1223 Metro Manila',
                'bedrooms' => 2,
                'bathrooms' => 2,
                'sqm' => 111,
                'type' => 'condominium',
                'contact_email' => 'downtownapt@example.com',
                'contact_messenger' => 'https://m.me/downtownapt',
                'contact_whatsapp' => '+639234567890',
                'swimming_pool' => false,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Doorman, Rooftop terrace',
                'lot_size' => null,
                'is_featured' => false,
                'is_exclusive' => false,
                'status' => 'for_sale',
            ],
            [
                'id' => 3,
                'title' => 'Suburban Home',
                'description' => 'Spacious family home in a quiet neighborhood',
                'price' => 37500000, // 37.5 million pesos
                'property_type' => 'house',
                'city' => 'Quezon City',
                'beds' => 4,
                'baths' => 3,
                'area_sqm' => 2500,
                'image' => self::IMAGE_PATH . 'property12.jpg',
                'featured' => true,
                'location' => 'Quezon City, Metro Manila',
                'property_address' => '789 Katipunan Avenue, Quezon City, 1108 Metro Manila',
                'bedrooms' => 4,
                'bathrooms' => 3,
                'sqm' => 232,
                'type' => 'house_and_lot',
                'contact_email' => 'suburbanhome@example.com',
                'contact_messenger' => 'https://m.me/suburbanhome',
                'contact_whatsapp' => '+639345678901',
                'swimming_pool' => true,
                'gym_access' => false,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Finished basement, Large backyard',
                'lot_size' => 800,
                'is_featured' => true,
                'is_exclusive' => false,
                'status' => 'for_sale',
            ]
        ];

        foreach ($existingProperties as $propertyData) {
            $propertyData['user_id'] = $users->random()->id;
            $property = Property::updateOrCreate(
                ['id' => $propertyData['id']],
                $propertyData
            );

            // Create sample images for each existing property
            for ($i = 1; $i <= 3; $i++) {
                $imagePath = self::IMAGE_PATH . "property{$i}.jpg";
                $alternativePath = self::IMAGE_PATH . "property{$i}.png";
                if (file_exists(public_path($imagePath))) {
                    $this->createPropertyImage($property, $imagePath, $i == 1);
                } elseif (file_exists(public_path($alternativePath))) {
                    $this->createPropertyImage($property, $alternativePath, $i == 1);
                } else {
                    Log::warning("Image file not found: {$imagePath} or {$alternativePath}");
                }
            }
        }

        // New properties for each type
        $propertyTypes = ['lot', 'house_and_lot', 'townhouse', 'condominium', 'apartment',];
        $cities = ['Makati', 'Cagayan de Oro', 'Taguig', 'Pasay', 'Davao', 'Mandaluyong', 'Cavite', 'Quezon City', 'Davao', 'Iligan'];

        // Define specific images for each property type with both PNG and JPG formats
        $typeImages = [
            'lot' => ['lot1.png', 'lot2.jpg', 'lot3.png', 'lot4.jpg'],
            'house_and_lot' => ['house1.png', 'house2.png', 'house3.png', 'house4.png'],
            'townhouse' => ['townhouse1.png', 'townhouse2.jpg', 'townhouse3.jpg', 'townhouse4.jpg'],
            'condominium' => ['condo1.jpg', 'condo2.jpg', 'condo3.jpg', 'condo4.jpg'],
            'apartment' => ['apartment1.jpg', 'apartment2.jpg', 'apartment3.jpg', 'apartment4.png'],

        ];

        $id = 4; // Start from 4 since we already have 3 existing properties

        foreach ($propertyTypes as $type) {
            for ($i = 1; $i <= 12; $i++) {
                $city = $cities[array_rand($cities)];
                $bedrooms = rand(1, 5);
                $bathrooms = rand(1, 3);
                $sqm = rand(50, 500);
                $price = rand(5000000, 50000000); // 5 million to 50 million pesos

                $property = Property::updateOrCreate(
                    ['id' => $id],
                    [
                        'title' => ucfirst($type) . ' Property ' . $i,
                        'description' => "This is a beautiful {$type} property located in {$city}. It features {$bedrooms} bedrooms and {$bathrooms} bathrooms, with a total area of {$sqm} square meters.",
                        'price' => $price,
                        'property_type' => $type,
                        'city' => $city,
                        'beds' => $bedrooms,
                        'baths' => $bathrooms,
                        'area_sqft' => round($sqm * 10.764),
                        'image' => self::IMAGE_PATH . "{$type}_property{$i}_1.jpg",
                        'featured' => (rand(1, 10) > 8), // 20% chance of being featured
                        'location' => $city . ', Philippines',
                        'property_address' => $this->generateFakeAddress($city),
                        'bedrooms' => $bedrooms,
                        'bathrooms' => $bathrooms,
                        'sqm' => $sqm,
                        'type' => $type,
                        'contact_email' => 'contact' . $i . '@example.com',
                        'contact_messenger' => 'https://m.me/property' . $i,
                        'contact_whatsapp' => '+63' . str_pad(rand(900000000, 999999999), 10, '0', STR_PAD_LEFT),
                        'user_id' => $users->random()->id,
                        'swimming_pool' => (bool)rand(0, 1),
                        'gym_access' => (bool)rand(0, 1),
                        'living_room' => (bool)rand(0, 1),
                        'dining_room' => (bool)rand(0, 1),
                        'additional_features' => $this->generateAdditionalFeatures(),
                        'lot_size' => $type === 'lot' ? $sqm : null,
                        'is_featured' => (bool)rand(0, 1),
                        'is_exclusive' => (bool)rand(0, 1),
                        'status' => 'for_sale',
                    ]
                );

                // Create images for each new property using $typeImages
                $typeImageFiles = $typeImages[$type];
                for ($j = 1; $j <= 4; $j++) {
                    $imageFile = $typeImageFiles[($j - 1) % count($typeImageFiles)];
                    $imagePath = self::IMAGE_PATH . $imageFile;

                    if (file_exists(public_path($imagePath))) {
                        $this->createPropertyImage($property, $imagePath, $j == 1);
                    } else {
                        // Try the alternative extension
                        $alternativeExtension = (pathinfo($imagePath, PATHINFO_EXTENSION) === 'jpg') ? 'png' : 'jpg';
                        $alternativePath = self::IMAGE_PATH . pathinfo($imageFile, PATHINFO_FILENAME) . '.' . $alternativeExtension;

                        if (file_exists(public_path($alternativePath))) {
                            $this->createPropertyImage($property, $alternativePath, $j == 1);
                        } else {
                            Log::warning("Image file not found: {$imagePath} or {$alternativePath}");
                        }
                    }
                }

                $id++; // Increment the ID for the next property
            }
        }
    }

    private function generateFakeAddress($city)
    {
        $streetNames = ['Maharlika', 'Mabini', 'Rizal', 'Bonifacio', 'Luna', 'Aguinaldo', 'Quezon'];
        $streetTypes = ['Street', 'Avenue', 'Boulevard', 'Road'];

        $number = rand(1, 999);
        $street = $streetNames[array_rand($streetNames)];
        $type = $streetTypes[array_rand($streetTypes)];

        return "{$number} {$street} {$type}, {$city}";
    }

    private function generateAdditionalFeatures()
    {
        $features = [
            'Balcony', 'Garden', 'Parking', 'Security System', 'Air Conditioning',
            'Elevator', 'Furnished', 'Pet-friendly', 'Storage Room', 'Fireplace'
        ];

        $selectedFeatures = array_rand($features, rand(2, 5));
        $featureList = array_map(function($index) use ($features) {
            return $features[$index];
        }, $selectedFeatures);

        return implode(', ', $featureList);
    }

    private function createPropertyImage($property, $imagePath, $isPrimary)
    {
        PropertyImage::updateOrCreate(
            [
                'property_id' => $property->id,
                'image_path' => $imagePath,
            ],
            ['is_primary' => $isPrimary]
        );
    }
}
