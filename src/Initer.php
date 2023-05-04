<?php declare( strict_types = 1 );

namespace PiotrPress;

class Initer extends Configer {
    public function __construct( string $file, array $default = [] ) {
        $this->file = $file;

        $contents = \is_file( $this->file ) ? \file( $this->file, \FILE_IGNORE_NEW_LINES | \FILE_SKIP_EMPTY_LINES ) : [];
        foreach ( $contents as $content ) {
            \preg_match( '/([^\=]*)\=(.*)/', $content, $matches );
            if ( $matches ) $data[ \trim( $matches[ 1 ] ) ] = $this->unwrap( \trim( $matches[ 2 ] ) );
        }

        $this->data = \array_merge( $default, $data ?? [] );
    }

    public function save() : bool {
        return (bool)\file_put_contents(
            $this->file,
            $this->__toString()
        );
    }

    public function __toString() : string {
        $data = $this->data;
        \array_walk( $data, function ( &$value, $key ) { $value = "$key=" . $this->convert( $value ); } );
        return \implode("\n", $data );
    }

    public function convert( $value ) : string {
        if ( true  === $value ) return 'true';
        if ( false === $value ) return 'false';
        if ( null  === $value ) return 'null';
        if ( ''    === $value ) return '';

        if ( \is_array( $value ) or \is_object( $value ) ) $value = \serialize( $value );
        return $this->wrap( (string)$value );
    }

    public function wrap( string $value ) : string {
        if ( ! \ctype_alnum( $value ) ) return '"' . $this->unwrap( $value ) . '"';
        return $value;
    }

    public function unwrap( string $value ) : string {
        if ( 2 < \strlen( $value ) and
            ( ( '"' === $value[ 0 ] and '"' === \substr( $value, -1 ) ) or
              ( "'" === $value[ 0 ] and "'" === \substr( $value, -1 ) ) ) )
            return \substr( $value, 1, -1 );
        return $value;
    }
}