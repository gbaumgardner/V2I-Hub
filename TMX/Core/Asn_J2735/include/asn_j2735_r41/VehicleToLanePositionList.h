/*
 * Generated by asn1c-0.9.27 (http://lionet.info/asn1c)
 * From ASN.1 module "EU"
 * 	found in "../J2735_R41_Source_mod.ASN"
 * 	`asn1c -gen-PER -fcompound-names -fincludes-quoted`
 */

#ifndef	_VehicleToLanePositionList_H_
#define	_VehicleToLanePositionList_H_


#include "asn_application.h"

/* Including external dependencies */
#include "asn_SEQUENCE_OF.h"
#include "constr_SEQUENCE_OF.h"

#ifdef __cplusplus
extern "C" {
#endif

/* Forward declarations */
struct VehicleToLanePosition;

/* VehicleToLanePositionList */
typedef struct VehicleToLanePositionList {
	A_SEQUENCE_OF(struct VehicleToLanePosition) list;
	
	/* Context for parsing across buffer boundaries */
	asn_struct_ctx_t _asn_ctx;
} VehicleToLanePositionList_t;

/* Implementation */
extern asn_TYPE_descriptor_t asn_DEF_VehicleToLanePositionList;

#ifdef __cplusplus
}
#endif

/* Referred external types */
#include "VehicleToLanePosition.h"

#endif	/* _VehicleToLanePositionList_H_ */
#include "asn_internal.h"
