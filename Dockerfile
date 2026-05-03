ARG PHP_VERSION=8.3
ARG PHP_VARIANT=cli
ARG RUST_VERSION=1.95.0
FROM php:${PHP_VERSION}-${PHP_VARIANT}-bookworm

ARG RUST_VERSION=1.95.0

ENV RUSTUP_HOME=/usr/local/rustup \
    CARGO_HOME=/usr/local/cargo \
    PATH=/usr/local/cargo/bin:$PATH

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
    && rm -rf /var/lib/apt/lists/*

RUN curl --proto '=https' --tlsv1.2 -fsSL https://sh.rustup.rs \
    | sh -s -- -y --profile minimal --default-toolchain ${RUST_VERSION} \
    && rustc --version \
    && cargo --version

WORKDIR /workspace
