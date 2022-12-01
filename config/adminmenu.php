<?php

return array(
    'menu' => [
        [
            "name" => "Cài đặt hệ thống",
            "route" => "admin.settings",
            "routes" => ["admin.settings"],
            "icon" => "fas fa-cogs"
        ],
        [
            "name" => "Quản trị viên",
            "route" => "admin.users",
            "routes" => ["admin.users","admin.user.add","admin.user.postAdd","admin.user.view","admin.user.postUpdate"],
            "icon" => "fas fa-user"
        ],
        [
            "name" => "Banner quảng cáo",
            "route" => "admin.advertisements",
            "routes" => ["admin.advertisements","admin.advertisement.add","admin.advertisement.view"],
            "icon" => "fas fa-ad"
        ],
        [
            "name" => "Sản phẩm gia công",
            "route" => "admin.products",
            "routes" => ["admin.products","admin.product.add","admin.product.view","admin.product.categories"],
            "icon" => "fas fa-tshirt",
            "children" => [
                [
                    "name" => "Danh mục",
                    "route" => "admin.product.categories",
                    "icon" => "far fa-circle"
                ],
                [
                    "name" => "Danh sách",
                    "route" => "admin.products",
                    "icon" => "far fa-circle"
                ],
                [
                    "name" => "Thêm mới",
                    "route" => "admin.product.add",
                    "icon" => "far fa-circle"
                ]
            ]
        ],
        [
            "name" => "Kinh nghiệm gia công",
            "route" => "admin.articles",
            "routes" => ["admin.articles","admin.article.add","admin.article.view"],
            "icon" => "fas fa-newspaper",
            "children" => [
                [
                    "name" => "Danh sách",
                    "route" => "admin.articles",
                    "icon" => "far fa-circle"
                ],
                [
                    "name" => "Thêm mới",
                    "route" => "admin.article.add",
                    "icon" => "far fa-circle"
                ]
            ]
        ],
        [
            "name" => "Thương hiệu",
            "route" => "admin.brands",
            "routes" => ["admin.brands","admin.brand.add","admin.brand.view"],
            "icon" => "fas fa-image",
            "children" => [
                [
                    "name" => "Danh sách",
                    "route" => "admin.brands",
                    "icon" => "far fa-circle"
                ],
                [
                    "name" => "Thêm mới",
                    "route" => "admin.brand.add",
                    "icon" => "far fa-circle"
                ]
            ]
        ],
        [
            "name" => "Hình ảnh sản phẩm",
            "route" => "admin.product-photos",
            "routes" => ["admin.product-photos","admin.product-photo.add","admin.product-photo.view"],
            "icon" => "fas fa-image",
            "children" => [
                [
                    "name" => "Danh sách",
                    "route" => "admin.product-photos",
                    "icon" => "far fa-circle"
                ],
                [
                    "name" => "Thêm mới",
                    "route" => "admin.product-photo.add",
                    "icon" => "far fa-circle"
                ]
            ]
        ],
        [
            "name" => "Gallery",
            "route" => "admin.galleries",
            "routes" => ["admin.galleries","admin.gallery.add","admin.gallery.view"],
            "icon" => "fas fa-images",
            "children" => [
                [
                    "name" => "Danh sách",
                    "route" => "admin.galleries",
                    "icon" => "far fa-circle"
                ],
                [
                    "name" => "Thêm mới",
                    "route" => "admin.gallery.add",
                    "icon" => "far fa-circle"
                ]
            ]
        ],
    ],  
    "advertisement_location" => [
        "1" => "Home Banner Page (1920x970)",
        "2" => "Footer Page Banner (1920x1079)",
        "7" => "Kinh Nghiệm Gia Công (Home Page) (1920x1200)",
        "8" => "Hình Ảnh Sản Phẩm (Home Page) (1920x1016)",
        "9" => "Liên Hệ (Home Page) (1920x1280)",
        "3" => "Blog Page Banner (1920x600)",
        "6" => "Product Page Banner (1920x600)",
        "4" => "Galleries Page Banner (1920x600)",
        "5" => "Product Photos Page Banner (1920x600)",
    ]
);