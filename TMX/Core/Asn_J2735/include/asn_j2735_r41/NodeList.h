/*
 * Generated by asn1c-0.9.27 (http://lionet.info/asn1c)
 * From ASN.1 module "DSRC"
 * 	found in "../J2735_R41_Source_mod.ASN"
 * 	`asn1c -gen-PER -fcompound-names -fincludes-quoted`
 */

#ifndef	_NodeList_H_
#define	_NodeList_H_


#include "asn_application.h"

/* Including external dependencies */
#include "Offsets.h"
#include "asn_SEQUENCE_OF.h"
#include "constr_SEQUENCE_OF.h"

#ifdef __cplusplus
extern "C" {
#endif

/* NodeList */
typedef struct NodeList {
	A_SEQUENCE_OF(Offsets_t) list;
	
	/* Context for parsing across buffer boundaries */
	asn_struct_ctx_t _asn_ctx;
} NodeList_t;

/* Implementation */
extern asn_TYPE_descriptor_t asn_DEF_NodeList;

#ifdef __cplusplus
}
#endif

#endif	/* _NodeList_H_ */
#include "asn_internal.h"
