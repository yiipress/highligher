PHP_VERSION ?= 8.3
PHP_VARIANT ?= cli
RUST_VERSION ?= 1.95.0
HIGHLIGHTER_VERSION ?= $(shell git describe --tags --dirty --always 2>/dev/null || git rev-parse --short HEAD 2>/dev/null || printf unknown)
DOCKER_IMAGE ?= highlighter-test:php$(subst .,,$(PHP_VERSION))-$(PHP_VARIANT)
TESTS ?= tests

.PHONY: docker-image test test-docker

docker-image:
	docker build --build-arg PHP_VERSION=$(PHP_VERSION) --build-arg PHP_VARIANT=$(PHP_VARIANT) --build-arg RUST_VERSION=$(RUST_VERSION) -t $(DOCKER_IMAGE) -f Dockerfile .

test: test-docker

test-docker: docker-image
	docker run --rm \
		-v "$(CURDIR):/workspace:ro" \
		-w /workspace \
		-e TESTS="$(TESTS)" \
		-e HIGHLIGHTER_VERSION="$(HIGHLIGHTER_VERSION)" \
		$(DOCKER_IMAGE) \
		sh -lc 'set -eu; \
			rm -rf /tmp/highlighter; \
			cp -a /workspace /tmp/highlighter; \
			cd /tmp/highlighter; \
			phpize; \
			./configure; \
			make -j"$$(nproc)"; \
			make test TESTS="$${TESTS}"'
