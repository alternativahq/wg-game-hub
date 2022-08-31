<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Str;

class DemoUsersSeeder extends Seeder
{
    public function run()
    {
        User::insert(
            $this->users()
                ->map(function ($item) {
                    unset($item['accounts']);
                    return $item;
                })
                ->toArray(),
        );
    }

    public function users()
    {
        return collect([
            [
                'id' => '0be3e8e4-c883-4717-9e0e-b62c03bb1f59',
                'name' => 'Danyel',
                'last_name' => 'Alkeddah',
                'email' => 'danyel@alternativa.dev',
                'is_admin' => 1,
                'image' => null,
                'username' => 'danyelkeddah',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => '2161335c-7660-4f06-a167-b16260c18948',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => 'b4eb761e-f5a7-4132-8d54-a37209013a13',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => '3eba7bff-9e3c-4a8d-a93e-8cffd3abf2c3',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => '8be7fc35-c815-4782-ac25-b5e1fe1a2a4a',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => '85808b7c-8bd4-4bb2-94c9-a7eaef2ca271',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => 'db5ea635-98ef-47a9-b56a-ca07675ccc8d',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => '14b8125b-154e-47ee-99ca-9e86792a8c78',
                ],
            ],
            [
                'id' => '4324992d-9a07-4a92-98d4-8cff6f1c19da',
                'name' => 'Halil',
                'last_name' => 'Uzer',
                'email' => 'halil@wodo.io',
                'is_admin' => 1,
                'image' => null,
                'username' => 'halil',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => '7b6e5c56-5ebb-4947-a5e6-d6c3c66ccbef',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => 'e8fac099-cf0e-4329-8375-d5f8ee3acc9e',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => 'ba436714-3b89-433a-9ed2-e935cc1efb8c',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => '62570547-4523-496b-8344-1e160bd1f50f',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => 'df67d577-3d83-4172-ae74-6245e3d6a24f',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => '26039cb6-38fb-414e-9ac2-a5f5b35f8fa3',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => '7a024706-a3ed-4645-8396-8807b17ac35c',
                ],
            ],
            [
                'id' => 'bd5720a7-4482-4a84-97e2-f7b973f3a475',
                'name' => 'Yaman',
                'last_name' => 'Jamal',
                'email' => 'yaman.jamal@alternativa.dev',
                'is_admin' => 1,
                'image' => null,
                'username' => 'yamanjamal',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => '933888c8-4c4b-4936-93e0-ec1573b18d95',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => '0b84d37f-1610-4d24-b3e6-8f4f3b86713e',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => 'deedac6c-e509-4ece-b775-320a498ff9d1',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => '87d9e66b-0ec8-4cc2-834e-8ff180cfded2',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => '3edb4e16-b5ff-4ba0-8127-986b6caeda87',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => '73557781-d1d8-4ae0-8900-509475f420f4',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => '28aba3ca-46de-4eac-851b-282a78c6fbb0',
                ],
            ],
            [
                'id' => '6b1dc9dd-9488-4871-9ac3-07beed286754',
                'name' => 'Serhat',
                'last_name' => 'Tanrikut',
                'email' => 'serhat@wodo.io',
                'is_admin' => 1,
                'image' => null,
                'username' => 'serhattanrikut',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => 'fffa37e8-9e06-4a5b-a3be-7f61f01472ae',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => '720f4829-dcb0-4c1a-ad5a-0f113680dd8e',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => 'c57b2169-99f3-4daa-a5f6-83c824a02a43',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => '6a5ce55b-c4a0-49dc-84e7-ab4cf03b2832',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => '65657691-380d-47d3-9aa8-06f7add9c9c1',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => '985a852d-b964-4157-b2cb-49b97f044e38',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => '110bf59f-5883-4664-8a54-30b2d603d389',
                ],
            ],
            [
                'id' => '8e94d65b-3588-41cd-9c18-4eb776b37be3',
                'name' => 'Bekir',
                'last_name' => 'Dag',
                'email' => 'bekir@wodo.io',
                'is_admin' => 1,
                'image' => null,
                'username' => 'bekirdag',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => 'a3a15b88-0289-41b3-8339-b72537f10b39',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => 'c6686661-736f-4dcc-bf55-758aed0e2122',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => '760e5c19-e5f8-43d2-9b4b-956e95d7d6a5',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => '7bab50bf-ecc6-468b-8196-cc0c6dcb264a',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => '626c7eda-5352-493e-814b-ab091e7ad207',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => 'bfd45144-c7d4-49ba-8749-ea4d33cbef7f',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => '690b6a5c-aab8-4e9a-b0b5-ffd1dc84efe5',
                ],
            ],
            [
                'id' => '60e0b30a-3adc-4bb6-ad98-671bd5e1ca8d',
                'name' => 'Murat',
                'last_name' => 'Inci',
                'email' => 'murat@wodo.io',
                'is_admin' => 1,
                'image' => null,
                'username' => 'muratdemirci',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => '0bf33eca-83e6-4609-bd75-1abdcca4da7b',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => 'bac65183-97e4-45c2-a39b-8d041fbff2b3',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => '9c1cf8f0-46c5-4973-ab6b-e75ecc9a4abb',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => 'e39955f2-4d1e-4ab2-a852-f5da56f07cf6',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => 'a6aa5dc7-fd1e-4cff-950e-8d1b477787fb',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => 'd90c382c-e8e2-47b8-ab0f-a10084a7fbca',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => 'ce5876be-c15c-4762-8fdd-b2b17f6cf9b4',
                ],
            ],
            [
                'id' => 'c13e37f7-aa81-40fd-bee2-5d7f2015955a',
                'name' => 'Gulsah',
                'last_name' => 'Smith',
                'email' => 'gulsah@wodo.io',
                'is_admin' => 1,
                'image' => null,
                'username' => 'gulsah',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => 'b354ab0a-ad69-47b4-a835-e05cf71f1a30',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => '09e00af6-7061-4331-8759-04ac6c2523b5',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => '684a807e-08a7-4aeb-aee6-50ce3767c30f',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => '4768d36e-f972-48b8-867f-d4326b881514',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => 'c316d98b-d2f7-4671-83e1-30675132ae6f',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => '85efd6c8-4138-474f-afef-e14b63fec396',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => '334e5a9f-bd5f-4a93-9b3b-d2cf16594003',
                ],
            ],
            [
                'id' => 'a40e3c00-3813-466b-892e-b1409eb6783a',
                'name' => 'Hasan',
                'last_name' => 'Smith',
                'email' => 'hasan@wodo.io',
                'is_admin' => 1,
                'image' => null,
                'username' => 'hasan',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => '5b569395-29c4-4cea-a6a0-50aa835ddaa8',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => '896c06b3-1fb1-419e-9481-1b95003c2902',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => '44361a56-6e15-40ba-8526-c731d4b24b54',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => '5d8ee13f-08f4-45f4-be92-e96277d2e45f',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => '181f34ce-208b-4507-977e-ccf115643fa1',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => '9cb26ceb-1e13-49b1-9fe5-a31f2cf46987',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => 'f5ec4334-47bc-430c-8c95-439291d017f1',
                ],
            ],
            [
                'id' => '4c92e9dd-0ad7-4ecb-8b1c-4a2dfd94cb13',
                'name' => 'Burak',
                'last_name' => 'Bolukbas',
                'email' => 'burakbolukbas@wodo.io',
                'is_admin' => 1,
                'image' => null,
                'username' => 'burakbolukbas',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => 'd9d61428-3b4f-4561-bdd5-f2136997c225',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => 'c34c2ec4-1e38-4c80-a611-edc4f403c854',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => '68183a4c-6745-4af5-a974-1278a9398689',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => '63b7836d-4a65-409e-8e93-72bfd6bb6249',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => '0f4577cb-45ed-44f9-8956-fd158fdd664f',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => 'c0eda01a-8fef-4997-831d-5c90e1d80697',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => 'c9bf2cc3-43af-4c39-a06e-18b7e1a619d7',
                ],
            ],
            [
                'id' => '623bfd6e-07a7-4d37-9969-5d55f1d9d980',
                'name' => 'Burak',
                'last_name' => 'Smith',
                'email' => 'burak@wodo.io',
                'is_admin' => 1,
                'image' => null,
                'username' => 'burak',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => 'c0842fe8-e7a3-46cf-ae44-b5ccbe3cce9c',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => 'ce631fc6-4e94-45cd-91f3-1811572384ac',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => 'a890507c-5bdb-4527-ad2c-4dc71d6581c4',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => '5f3e5699-e6b4-4922-bb33-602f57a14d95',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => '770c998b-8f59-465f-bf21-4814b9d4c6b8',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => '43649ff9-7366-4e2d-9643-92719e263d43',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => '37953786-2525-424b-82c6-d1422c744a50',
                ],
            ],
            [
                'id' => '40b48fa3-5cd4-4019-bd4b-834c7cee702e',
                'name' => 'Sevban',
                'last_name' => 'Smith',
                'email' => 'sevban@wodo.io',
                'is_admin' => 1,
                'image' => null,
                'username' => 'sevban',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => 'da8eba7c-ed19-43f1-aa4a-5ef0cbf45da4',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => '892c31f3-835c-4472-b38b-dac701699a2d',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => 'b2588651-999e-477a-b5f0-3353d2acadeb',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => 'b5f47265-6aa7-452e-b5c4-ecfe53ae8c57',
                    //                    BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => '2920aa2f-5ad7-4e99-b6bf-ec2da5d22211',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => 'f86a271f-a8bc-4f05-b17c-ee9737868cd6',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => 'cc7e14a4-818f-4a05-bffe-293a801fc30c',
                ],
            ],
            [
                'id' => 'f0a361eb-331a-411c-bae5-5d562adf48de',
                'name' => 'Pam',
                'last_name' => 'Smith',
                'email' => 'pam@wodo.io',
                'is_admin' => 1,
                'image' => null,
                'username' => 'pam',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => now(),
                'updated_at' => now(),
                'accounts' => [
                    //                    XWGT
                    '15f89a3a-c8dd-4be7-86df-cf450a7cfc13' => '584465c4-70ee-4086-bbe8-e579912e0d0d',
                    //                    XNO
                    '9f343108-afdc-422e-9d40-9ecd83d4cd67' => '2e60d982-30c9-4210-9d84-323866463362',
                    //                    BAN
                    '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d' => '0eefab5f-9d28-4547-b73a-7e72d4fbb331',
                    //                    ETH
                    'a8745d72-53a7-493e-b207-7b7ebbec0d40' => '55222ba7-22b5-4d93-a453-91f1d70f634d',
                    // BSC
                    'a3a5a587-7799-4b47-b72a-ec2eb7d0280f' => '06defbcd-92bc-4152-8c2d-eaaa7c205d6d',
                    //                    AVAX
                    'd3a35442-0a55-46c3-850b-320a90ea9a7b' => '5e86f8d2-8ca4-4c54-a6ab-e2f69d9658c1',
                    //                    SOL
                    '85e1fe15-fa5d-4f2c-ae45-f9c643d51657' => '1b273cd0-3e23-4015-b619-f0b4ca4280b1',
                ],
            ],
        ]);
    }
}
